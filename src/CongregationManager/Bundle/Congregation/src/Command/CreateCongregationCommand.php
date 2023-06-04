<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Congregation\Command;

use CongregationManager\Component\Congregation\Application\CreateCongregation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;
use Webmozart\Assert\Assert;

final class CreateCongregationCommand extends Command
{
    use LockableTrait;

    private const CREATE_CONGREGATION_COMMAND_EVENT_NAME = 'create-congregation-command';

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private SymfonyStyle $io;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private string $congregationName;

    public function __construct(
        private CreateCongregation $createCongregation,
        private EntityManagerInterface $entityManager,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create a new congregation.')
            ->setHelp($this->getCommandHelp())
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->io->title('Create Congregation command interactive wizard');
        $this->io->text(['Now we\'ll ask you for the value of the necessary arguments.']);

        $congregationName = $this->io->ask('Congregation name', null, [$this, 'validateString']);
        Assert::string($congregationName);
        $this->congregationName = $congregationName;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (! $this->lock()) {
            $this->io->error('The command is already running in another process.');

            return Command::FAILURE;
        }
        $stopwatch = new Stopwatch();
        $stopwatch->start(self::CREATE_CONGREGATION_COMMAND_EVENT_NAME);

        $this->createCongregation->create($this->congregationName);
        $this->entityManager->flush();

        $this->io->success('Congregation successfully created');
        $event = $stopwatch->stop(self::CREATE_CONGREGATION_COMMAND_EVENT_NAME);
        if ($output->isVerbose()) {
            $this->io->comment(
                sprintf(
                    'Elapsed time: %.2f ms / Consumed memory: %.2f MB',
                    $event->getDuration(),
                    $event->getMemory() / (1024 ** 2)
                )
            );
        }
        $this->release();

        return Command::SUCCESS;
    }

    private function getCommandHelp(): string
    {
        return <<<'CODE_SAMPLE'
            The <info>%command.name%</info> command will guide you through the creation of a new congregation.

              <info>php %command.full_name%</info>

            The command will ask you to provide the necessary arguments like the name of the congregation.
        CODE_SAMPLE;
    }

    private function validateString(?string $string): string
    {
        if (empty($string)) {
            throw new InvalidArgumentException('The string can not be empty.');
        }

        return $string;
    }
}
