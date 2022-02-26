<?php

namespace CongregationManager\Tests\Integration\Command;

use CongregationManager\Domain\User\Model\AdminUser;
use CongregationManager\Domain\User\Model\AppUser;
use CongregationManager\Infrastructure\User\Repository\AdminUserRepository;
use CongregationManager\Infrastructure\User\Repository\AppUserRepository;

final class AddUserCommandTest extends AbstractCommandTest
{
    private array $appUserData = [
        'email' => 'walkbrend@email.com',
        'password' => 'foobar',
    ];

    private array $adminUserData = [
        'email' => 'admin@cm.org',
        'password' => 'password',
    ];

    public function testCreateAppUserNonInteractive(): void
    {
        $this->executeCommand($this->appUserData);

        $this->assertAppUserCreated();
    }

    public function testCreateAppUserInteractive(): void
    {
        $this->executeCommand(
            [],
            array_values($this->appUserData)
        );

        $this->assertAppUserCreated();
    }

    public function testCreateAdminUserNonInteractive(): void
    {
        $this->executeCommand(array_merge($this->adminUserData, ['--admin' => 1]));

        $this->assertAdminUserCreated();
    }

    public function testCreateSuperAdminUserNonInteractive(): void
    {
        $this->executeCommand(array_merge($this->adminUserData, ['--super-admin' => 1]));

        $this->assertAdminUserCreated(true);
    }

    protected function getCommandServiceDefinition(): string
    {
        return 'cm.command.create_user';
    }

    private function assertAppUserCreated(): void
    {
        /** @var AppUser $user */
        $user = self::getContainer()->get(AppUserRepository::class)->findOneByEmail($this->appUserData['email']);
        $this->assertNotNull($user);

        $this->assertTrue(self::getContainer()->get('security.user_password_hasher')->isPasswordValid($user, $this->appUserData['password']));
        $this->assertSame(['ROLE_USER'], $user->getRoles());
    }

    private function assertAdminUserCreated(bool $superAdmin = false): void
    {
        /** @var AdminUser $user */
        $user = self::getContainer()->get(AdminUserRepository::class)->findOneByEmail($this->adminUserData['email']);
        $this->assertNotNull($user);

        $this->assertTrue(self::getContainer()->get('security.user_password_hasher')->isPasswordValid($user, $this->adminUserData['password']));
        $this->assertSame($superAdmin ? ['ROLE_SUPER_ADMIN'] : ['ROLE_ADMIN'], $user->getRoles());
    }
}
