<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Command;

use CongregationManager\Application\Congregation\CreateBrother;
use CongregationManager\Application\Congregation\CreateCongregation;
use CongregationManager\Infrastructure\Common\Repository\OldCM\AppUserRepositoryInterface as OldAppUserRepositoryInterface;
use CongregationManager\Infrastructure\Common\Repository\OldCM\BrotherRepositoryInterface as OldBrotherRepositoryInterface;
use CongregationManager\Infrastructure\Common\Repository\OldCM\CongregationRepositoryInterface as OldCongregationRepositoryInterface;
use CongregationManager\Infrastructure\User\Action\CreateAppUser;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;
use Webmozart\Assert\Assert;

final class ImportFromOldCMCommand extends Command
{
    use LockableTrait;

    private const OLD_CONGREGATION_ID_ARGUMENT_CODE = 'old-congregation-id';

    /** @psalm-suppress PropertyNotSetInConstructor */
    private SymfonyStyle $io;

    public function __construct(
        private OldCongregationRepositoryInterface $oldCongregationRepository,
        private CreateCongregation $createCongregation,
        private EntityManagerInterface $entityManager,
        private OldBrotherRepositoryInterface $oldBrotherRepository,
        private CreateBrother $createBrother,
        private OldAppUserRepositoryInterface $oldAppUserRepository,
        private CreateAppUser $createAppUser,
        private ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setHelp($this->getCommandHelp())
            ->addArgument(self::OLD_CONGREGATION_ID_ARGUMENT_CODE, InputArgument::REQUIRED, 'The old id of the congregation to import')
        ;
    }


    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if ($input->getArgument(self::OLD_CONGREGATION_ID_ARGUMENT_CODE) !== null) {
            return;
        }

        $this->io->title('Import From Old Congregation Manager Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console ' . (string) $this->name . ' old-congregation-id',
            '',
            'Now we\'ll ask you for the value of all the missing command arguments.',
        ]);

        /** @var null|mixed $oldCongregationId */
        $oldCongregationId = $input->getArgument(self::OLD_CONGREGATION_ID_ARGUMENT_CODE);
        if (null === $oldCongregationId) {
            /** @var int $oldCongregationId */
            $oldCongregationId = $this->io->ask('Old congregation id', null, [$this, 'validateOldCongregationId']);
            $input->setArgument(self::OLD_CONGREGATION_ID_ARGUMENT_CODE, $oldCongregationId);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $this->io->error('The command is already running in another process.');

            return Command::FAILURE;
        }
        $stopwatch = new Stopwatch();
        $stopwatch->start('import-from-old-cm-command');

        // make sure to validate the user data is correct
        $oldCongregationId = $this->validateOldCongregationId($input->getArgument(self::OLD_CONGREGATION_ID_ARGUMENT_CODE));
        $oldCongregation = $this->oldCongregationRepository->findOneById($oldCongregationId);

        if (count($oldCongregation) === 0) {
            $this->io->error('No old congregation founded');

            return Command::FAILURE;
        }
        $oldCongregation = reset($oldCongregation);
        $congregation = $this->createCongregation->create($oldCongregation['name']);

        foreach ($this->oldBrotherRepository->findAllByCongregation($oldCongregationId) as $oldBrother) {
            $brother = $this->createBrother->create(
                $oldBrother['name'],
                $oldBrother['surname'],
                $congregation,
                (bool) $oldBrother['male'],
                $oldBrother['middle_name'],
                $oldBrother['birth_date'] ? new DateTime($oldBrother['birth_date']) : null,
                $oldBrother['baptism_date'] ? new DateTime($oldBrother['baptism_date']) : null,
            );
            $oldAppUser = $this->oldAppUserRepository->findOneByBrother((int) $oldBrother['id']);
            if (count($oldAppUser) === 0) {
                continue;
            }
            $oldAppUser = reset($oldAppUser);
            $this->createAppUser->create(
                $brother,
                $oldAppUser['email'],
                null,
                'it',
                $oldAppUser['password']
            );
        }

        $this->entityManager->flush();

        $event = $stopwatch->stop('import-from-old-cm-command');
        $this->io->comment(sprintf('Elapsed time: %.2f ms / Consumed memory: %.2f MB', $event->getDuration(), $event->getMemory() / (1024 ** 2)));

        $this->release();

        return Command::SUCCESS;
    }

    public function validateOldCongregationId(mixed $oldCongregationId): int
    {
        if (empty($oldCongregationId)) {
            throw new InvalidArgumentException('The old congregation id can not be empty.');
        }
        if (is_int($oldCongregationId)) {
            return $oldCongregationId;
        }
        Assert::string($oldCongregationId);

        return (int) $oldCongregationId;
    }

    private function getCommandHelp(): string
    {
        return <<<'HELP'
            The <info>%command.name%</info> command imports congregation, brothers and users from an old CM congregation:

              <info>php %command.full_name%</info> <comment>old-congregation-id</comment>
            HELP;
    }
}
