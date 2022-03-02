<?php


namespace CongregationManager\Infrastructure\User\Command;

use CongregationManager\Domain\Congregation\Model\Brother;
use CongregationManager\Domain\Congregation\Model\Congregation;
use CongregationManager\Infrastructure\Common\Utils\Validator\Validator;
use CongregationManager\Infrastructure\User\Model\AdminUser;
use CongregationManager\Infrastructure\User\Model\AppUser;
use CongregationManager\Infrastructure\User\Repository\AdminUserRepository;
use CongregationManager\Infrastructure\User\Repository\AppUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use function Symfony\Component\String\u;

final class AddUserCommand extends Command
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    private SymfonyStyle $io;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private Validator $validator,
        private AppUserRepository $appUserRepository,
        private AdminUserRepository $adminUserRepository
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setHelp($this->getCommandHelp())
            ->addArgument('email', InputArgument::OPTIONAL, 'The email of the new user')
            ->addArgument('password', InputArgument::OPTIONAL, 'The plain password of the new user')
            ->addOption('admin', 'a', InputOption::VALUE_NONE, 'If set, the user is created as an administrator')
            ->addOption('super-admin', 's', InputOption::VALUE_NONE, 'If set, the user is created as a super administrator')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if (null !== $input->getArgument('password') && null !== $input->getArgument('email')) {
            return;
        }

        $this->io->title('Add User Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console app:add-user email@example.com password',
            '',
            'Now we\'ll ask you for the value of all the missing command arguments.',
        ]);

        // Ask for the email if it's not defined
        /** @var ?string $email */
        $email = $input->getArgument('email');
        if (null !== $email) {
            $this->io->text(' > <info>Email</info>: ' . $email);
        } else {
            /** @var string $email */
            $email = $this->io->ask('Email', null, [$this->validator, 'validateEmail']);
            $input->setArgument('email', $email);
        }

        // Ask for the password if it's not defined
        /** @var ?string $password */
        $password = $input->getArgument('password');
        if (null !== $password) {
            $this->io->text(' > <info>Password</info>: ' . u('*')->repeat(u($password)->length()));
        } else {
            /** @var string $password */
            $password = $this->io->askHidden('Password (your type will be hidden)', [$this->validator, 'validatePassword']);
            $input->setArgument('password', $password);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('add-user-command');

        /** @var ?string $email */
        $email = $input->getArgument('email');
        /** @var ?string $plainPassword */
        $plainPassword = $input->getArgument('password');
        $isSuperAdmin = (bool) $input->getOption('super-admin');
        $isAdmin = $isSuperAdmin === true || (bool) $input->getOption('admin');

        // make sure to validate the user data is correct
        $this->validateUserData($email, $plainPassword, $isAdmin);
        if ($email === null) {
            return Command::FAILURE;
        }
        if ($plainPassword === null) {
            return Command::FAILURE;
        }

        // create the user and hash its password
        if ($isAdmin) {
            $user = AdminUser::create($email);
            $user->setRoles([$isSuperAdmin ? 'ROLE_SUPER_ADMIN' : 'ROLE_ADMIN']);
        } else {
            # TODO: Change AddUserCommand
            $congregation = new Congregation('Congregation');
            $brother = new Brother('Name', 'Surname', $congregation);
            $this->entityManager->persist($congregation);
            $this->entityManager->persist($brother);
            $user = new AppUser($brother, $email);
        }
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->io->success(sprintf('User was successfully created: %s', $user->getEmail()));

        $event = $stopwatch->stop('add-user-command');
        if ($output->isVerbose()) {
            $this->io->comment(sprintf('New user with role %s database id: %d / Elapsed time: %.2f ms / Consumed memory: %.2f MB', implode(', ', $user->getRoles()), (string) $user->getId(), $event->getDuration(), $event->getMemory() / (1024 ** 2)));
        }

        return Command::SUCCESS;
    }

    private function validateUserData(?string $email, ?string $plainPassword, bool $isAdmin): void
    {
        // validate password and email if is not this input means interactive.
        $this->validator->validateEmail($email);
        $this->validator->validatePassword($plainPassword);

        // check if a user with the same email already exists.
        if ($isAdmin) {
            $existingEmail = $this->adminUserRepository->findOneBy(['email' => $email]);
        } else {
            $existingEmail = $this->appUserRepository->findOneBy(['email' => $email]);
        }

        if (null !== $existingEmail) {
            throw new RuntimeException(sprintf('There is already a user registered with the "%s" email.', (string) $email));
        }
    }

    private function getCommandHelp(): string
    {
        return <<<'HELP'
            The <info>%command.name%</info> command creates new users and saves them in the database:

              <info>php %command.full_name%</info> <comment>email password</comment>

            By default the command creates regular users. To create administrator users, add the <comment>--admin</comment> option:
              <info>php %command.full_name%</info> email password<comment>--admin</comment>
              
            To create super administrator users, add the <comment>--super-admin</comment> option:
              <info>php %command.full_name%</info> email password<comment>--super-admin</comment>

            If you omit any of the two required arguments, the command will ask you to
            provide the missing values:

              # command will ask you for the password
              <info>php %command.full_name%</info> <comment>email</comment>

              # command will ask you for all arguments
              <info>php %command.full_name%</info>
            HELP;
    }
}
