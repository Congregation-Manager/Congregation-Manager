<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Tests\Application;

use CongregationManager\Component\Core\Application\CreateAdminUser;
use CongregationManager\Component\Core\Domain\AdminUser;
use CongregationManager\Component\Core\Domain\Factory\AdminUserFactory;
use CongregationManager\Component\Core\Infrastructure\InMemory\Repository\AdminUserRepository;
use CongregationManager\Component\User\Infrastructure\InMemory\Hasher\UserPasswordHasher;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class CreateAdminUserTest extends TestCase
{
    /**
     * @phpstan-var AdminUserRepository<covariant AdminUser>
     * @psalm-var AdminUserRepository<AdminUser>
     */
    private AdminUserRepository $adminUserRepository;

    private CreateAdminUser $createAdminUser;

    private UserPasswordHasher $userPasswordHasher;

    #[\Override]
    protected function setUp(): void
    {
        $this->adminUserRepository = new AdminUserRepository();
        $this->userPasswordHasher = new UserPasswordHasher();
        $this->createAdminUser = new CreateAdminUser(
            new AdminUserFactory(),
            $this->adminUserRepository,
            $this->userPasswordHasher
        );
    }

    public function testThatItCreatesANewAdminUser(): void
    {
        $adminUser = $this->createAdminUser->create('info@email.com', 'p455w0rd', 'it_IT');

        $this->assertSame('info@email.com', $adminUser->getEmail());
        $this->assertSame(
            $this->userPasswordHasher->hashPasswordForUser('p455w0rd', $adminUser),
            $adminUser->getPassword()
        );
        $this->assertSame('it_IT', $adminUser->getLocaleCode());
        $adminUsers = $this->adminUserRepository->adminUsers;
        $this->assertSame(reset($adminUsers), $adminUser);
    }

    public function testThatItCreatesANewAdminUserWithoutPasswordIfNotSpecified(): void
    {
        $adminUser = $this->createAdminUser->create('info@email.com', null, 'it_IT');

        $this->assertSame('info@email.com', $adminUser->getEmail());
        $this->assertNull($adminUser->getPassword());
        $this->assertSame('it_IT', $adminUser->getLocaleCode());
        $adminUsers = $this->adminUserRepository->adminUsers;
        $this->assertSame(reset($adminUsers), $adminUser);
    }

    public function testThatItCreatesANewAdminUserWithoutLocaleIfNotSpecified(): void
    {
        $adminUser = $this->createAdminUser->create('info@email.com', 'p455w0rd', null);

        $this->assertSame('info@email.com', $adminUser->getEmail());
        $this->assertSame(
            $this->userPasswordHasher->hashPasswordForUser('p455w0rd', $adminUser),
            $adminUser->getPassword()
        );
        $this->assertNull($adminUser->getLocaleCode());
        $adminUsers = $this->adminUserRepository->adminUsers;
        $this->assertSame(reset($adminUsers), $adminUser);
    }
}
