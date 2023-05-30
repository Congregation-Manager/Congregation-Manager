<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Application\User;

use CongregationManager\Component\User\Application\CreateAdminUser;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;
use CongregationManager\Component\User\Domain\Repository\AdminUserRepositoryInterface;
use CongregationManager\Component\User\Domain\UserInterface;
use CongregationManager\Tests\Repository\AdminUserRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @internal
 * @coversNothing
 */
final class CreateAdminUserTest extends TestCase
{
    use ProphecyTrait;

    private AdminUserRepositoryInterface $adminUserRepository;

    private CreateAdminUser $createAdminUser;

    /**
     * @var ObjectProphecy|UserPasswordHasherInterface
     */
    private $userPasswordHasher;

    protected function setUp(): void
    {
        $this->adminUserRepository = new AdminUserRepository();
        $this->userPasswordHasher = $this->prophesize(UserPasswordHasherInterface::class);
        $this->userPasswordHasher->hashPasswordForUser('p455w0rd', Argument::type(UserInterface::class))->willReturn(
            '3r34fQDEWw3d'
        );
        $this->createAdminUser = new CreateAdminUser($this->adminUserRepository, $this->userPasswordHasher->reveal());
    }

    public function testThatItCreatesANewAdminUser(): void
    {
        $adminUser = $this->createAdminUser->create('info@email.com', 'p455w0rd', 'it_IT');

        $this->assertSame('info@email.com', $adminUser->getEmail());
        $this->assertSame('3r34fQDEWw3d', $adminUser->getPassword());
        $this->assertSame('it_IT', $adminUser->getLocaleCode());
        $this->assertSame($this->adminUserRepository->findAll()->first(), $adminUser);
    }

    public function testThatItCreatesANewAdminUserWithoutPasswordIfNotSpecified(): void
    {
        $adminUser = $this->createAdminUser->create('info@email.com', null, 'it_IT');

        $this->assertSame('info@email.com', $adminUser->getEmail());
        $this->assertNull($adminUser->getPassword());
        $this->assertSame('it_IT', $adminUser->getLocaleCode());
        $this->assertSame($this->adminUserRepository->findAll()->first(), $adminUser);
    }

    public function testThatItCreatesANewAdminUserWithoutLocaleIfNotSpecified(): void
    {
        $adminUser = $this->createAdminUser->create('info@email.com', 'p455w0rd', null);

        $this->assertSame('info@email.com', $adminUser->getEmail());
        $this->assertSame('3r34fQDEWw3d', $adminUser->getPassword());
        $this->assertNull($adminUser->getLocaleCode());
        $this->assertSame($this->adminUserRepository->findAll()->first(), $adminUser);
    }
}
