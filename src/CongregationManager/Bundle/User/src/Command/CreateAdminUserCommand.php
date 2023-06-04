<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Command;

use CongregationManager\Bundle\User\Action\CreateAdminUser;
use CongregationManager\Bundle\User\Utils\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;
use Webmozart\Assert\Assert;

final class CreateAdminUserCommand extends Command
{
    use LockableTrait;

    private const CREATE_ADMIN_USER_COMMAND_EVENT_NAME = 'create-admin-user-command';

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private SymfonyStyle $io;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private string $userEmail;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private string $userPassword;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private string $userLocale;

    /**
     * @var string[]
     */
    private array $locales;

    public function __construct(
        private CreateAdminUser $createAdminUser,
        private EntityManagerInterface $entityManager,
        private Validator $validator,
        private string $defaultLocale,
        string $locales,
        string $name
    ) {
        $this->locales = explode('|', $locales);
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create a new admin user.')
            ->setHelp($this->getCommandHelp())
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->io->title('Create admin user command interactive wizard');
        $this->io->text(['Now we\'ll ask you for the value of the necessary arguments.']);

        $userEmail = $this->io->ask('Email', null, [$this->validator, 'validateEmail']);
        Assert::string($userEmail);
        $this->userEmail = $userEmail;

        $userPassword = $this->io->ask('Password', null, [$this->validator, 'validatePassword']);
        Assert::string($userPassword);
        $this->userPassword = $userPassword;

        $userLocale = $this->io->ask(
            sprintf('Locale [%s]', implode(',', $this->locales)),
            $this->defaultLocale,
            [$this->validator, 'validateString']
        );
        Assert::string($userLocale);
        Assert::inArray($userLocale, $this->locales);
        $this->userLocale = $userLocale;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (! $this->lock()) {
            $this->io->error('The command is already running in another process.');

            return Command::FAILURE;
        }
        $stopwatch = new Stopwatch();
        $stopwatch->start(self::CREATE_ADMIN_USER_COMMAND_EVENT_NAME);

        $this->createAdminUser->create($this->userEmail, $this->userPassword, $this->userLocale);
        $this->entityManager->flush();

        $this->io->success('Admin user successfully created');
        $event = $stopwatch->stop(self::CREATE_ADMIN_USER_COMMAND_EVENT_NAME);
        if ($output->isVerbose()) {
            $this->io->comment(
                sprintf(
                    'Elapsed time: %.2f ms / Consumed memory: %.2f MB',
                    $event->getDuration(),
                    $event->getMemory() / (1024 ** 2)
                )
            );
        }

        return Command::SUCCESS;
    }

    private function getCommandHelp(): string
    {
        return <<<'CODE_SAMPLE'
            The <info>%command.name%</info> command will guide you through the creation of a new admin user.

              <info>php %command.full_name%</info>

            The command will ask you to provide the necessary arguments like the email and the password of the user.
        CODE_SAMPLE;
    }
}
