<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Tests\Command;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class CreateAdminUserCommandTest extends KernelTestCase
{
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $appEntityManager = self::getContainer()->get('doctrine.orm.entity_manager');
        $purger = new ORMPurger($appEntityManager);
        $purger->purge();
    }

    public function testCreateAdminUserInteractive(): void
    {
        $this->executeCommand([], ['admin@cm.org', 'password', 'en']);

        $adminUserRepository = self::getContainer()->get('congregation_manager_user.repository.admin_user');
        $adminUsers = $adminUserRepository->findAll();
        $this->assertCount(1, $adminUsers);

        $adminUser = $adminUsers[0];
        $this->assertSame('admin@cm.org', $adminUser->getEmail());
        $this->assertSame('en', $adminUser->getLocaleCode());
        $this->assertTrue(
            self::getContainer()->get('security.user_password_hasher')->isPasswordValid($adminUser, 'password')
        );
    }

    public function testCreateAdminUserDefaultLocale(): void
    {
        $this->executeCommand([], ['admin@cm.org', 'password', null]);

        $adminUserRepository = self::getContainer()->get('congregation_manager_user.repository.admin_user');
        $adminUsers = $adminUserRepository->findAll();
        $this->assertCount(1, $adminUsers);

        $adminUser = $adminUsers[0];
        $this->assertSame('admin@cm.org', $adminUser->getEmail());
        $this->assertSame('en', $adminUser->getLocaleCode());
        $this->assertTrue(
            self::getContainer()->get('security.user_password_hasher')->isPasswordValid($adminUser, 'password')
        );
    }

    public function testItDoesNotCreateAdminUserIfLocaleIsNotValid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->executeCommand([], ['admin@cm.org', 'password', 'ge']);
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the execution of a command.
     *
     * @param array<array-key, string> $arguments All the arguments passed when executing the command
     * @param array<array-key, string|null> $inputs    The (optional) answers given to the command when it asks for the value of the missing arguments
     */
    private function executeCommand(array $arguments, array $inputs = []): CommandTester
    {
        self::bootKernel();

        // this uses a special testing container that allows you to fetch private services
        /** @var Command $command */
        $command = self::getContainer()->get('congregation_manager_user.command.craete_admin_user');
        $kernel = self::$kernel;
        Assert::isInstanceOf($kernel, KernelInterface::class);
        $command->setApplication(new Application($kernel));

        $commandTester = new CommandTester($command);
        $commandTester->setInputs($inputs);
        $commandTester->execute($arguments);

        return $commandTester;
    }
}
