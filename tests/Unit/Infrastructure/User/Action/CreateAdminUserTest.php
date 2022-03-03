<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Infrastructure\User\Action;

use CongregationManager\Domain\User\Hasher\UserPasswordHasherInterface;
use CongregationManager\Domain\User\Model\UserInterface;
use CongregationManager\Domain\User\Repository\AdminUserRepositoryInterface;
use CongregationManager\Infrastructure\User\Action\CreateAdminUser;
use CongregationManager\Tests\Repository\AdminUserRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class CreateAdminUserTest extends TestCase
{
    use ProphecyTrait;

    private AdminUserRepositoryInterface $adminUserRepository;

    private CreateAdminUser $createAdminUser;

    /** @var ObjectProphecy|UserPasswordHasherInterface  */
    private $userPasswordHasher;

    protected function setUp(): void
    {
        $this->adminUserRepository = new AdminUserRepository();
        $this->userPasswordHasher = $this->prophesize(UserPasswordHasherInterface::class);
        $this->userPasswordHasher->hashPasswordForUser('p455w0rd', Argument::type(UserInterface::class))->willReturn('3r34fQDEWw3d');
        $this->createAdminUser = new CreateAdminUser($this->adminUserRepository, $this->userPasswordHasher->reveal());
    }

    public function test_that_it_creates_a_new_admin_user(): void
    {
        $adminUser = $this->createAdminUser->create('info@email.com', 'p455w0rd', 'it_IT');

        $this->assertEquals('info@email.com', $adminUser->getEmail());
        $this->assertEquals('3r34fQDEWw3d', $adminUser->getPassword());
        $this->assertEquals('it_IT', $adminUser->getLocaleCode());
        $this->assertEquals($this->adminUserRepository->findAll()->first(), $adminUser);
    }

    public function test_that_it_creates_a_new_admin_user_without_password_if_not_specified(): void
    {
        $adminUser = $this->createAdminUser->create('info@email.com', null, 'it_IT');

        $this->assertEquals('info@email.com', $adminUser->getEmail());
        $this->assertNull($adminUser->getPassword());
        $this->assertEquals('it_IT', $adminUser->getLocaleCode());
        $this->assertEquals($this->adminUserRepository->findAll()->first(), $adminUser);
    }

    public function test_that_it_creates_a_new_admin_user_without_locale_if_not_specified(): void
    {
        $adminUser = $this->createAdminUser->create('info@email.com', 'p455w0rd', null);

        $this->assertEquals('info@email.com', $adminUser->getEmail());
        $this->assertEquals('3r34fQDEWw3d', $adminUser->getPassword());
        $this->assertNull($adminUser->getLocaleCode());
        $this->assertEquals($this->adminUserRepository->findAll()->first(), $adminUser);
    }
}
