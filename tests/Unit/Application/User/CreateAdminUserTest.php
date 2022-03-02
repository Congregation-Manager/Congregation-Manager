<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Application\User;

use CongregationManager\Application\User\CreateAdminUser;
use CongregationManager\Domain\User\Repository\AdminUserRepositoryInterface;
use CongregationManager\Tests\Repository\AdminUserRepository;
use PHPUnit\Framework\TestCase;

class CreateAdminUserTest extends TestCase
{
    private AdminUserRepositoryInterface $adminUserRepository;

    private CreateAdminUser $createAdminUser;

    protected function setUp(): void
    {
        $this->adminUserRepository = new AdminUserRepository();
        $this->createAdminUser = new CreateAdminUser($this->adminUserRepository);
    }

    public function test_that_it_creates_a_new_admin_user(): void
    {
        $adminUser = $this->createAdminUser->create('info@email.com', 'p455w0rd', 'it_IT');

        $this->assertEquals('info@email.com', $adminUser->getEmail());
        $this->assertEquals('p455w0rd', $adminUser->getPassword());
        $this->assertEquals('it_IT', $adminUser->getLocaleCode());
        $this->assertEquals($this->adminUserRepository->findAll()->first(), $adminUser);
    }
}
