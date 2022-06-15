<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Application\User;

use CongregationManager\Application\User\CreateAppUser;
use CongregationManager\Domain\Congregation\Model\Brother;
use CongregationManager\Domain\Congregation\Model\Congregation;
use CongregationManager\Domain\User\Hasher\UserPasswordHasherInterface;
use CongregationManager\Domain\User\Model\UserInterface;
use CongregationManager\Domain\User\Repository\AppUserRepositoryInterface;
use CongregationManager\Tests\Repository\AppUserRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @internal
 * @coversNothing
 */
final class CreateAppUserTest extends TestCase
{
    use ProphecyTrait;

    private AppUserRepositoryInterface $appUserRepository;

    private CreateAppUser $createAppUser;

    /**
     * @var ObjectProphecy|UserPasswordHasherInterface
     */
    private $userPasswordHasher;

    protected function setUp(): void
    {
        $this->appUserRepository = new AppUserRepository();
        $this->userPasswordHasher = $this->prophesize(UserPasswordHasherInterface::class);
        $this->userPasswordHasher->hashPasswordForUser('p455w0rd', Argument::type(UserInterface::class))->willReturn(
            '3r34fQDEWw3d'
        );
        $this->createAppUser = new CreateAppUser($this->appUserRepository, $this->userPasswordHasher->reveal());
    }

    public function testThatItCreatesANewAppUser(): void
    {
        $brother = new Brother('John', 'Ritz', new Congregation('Carrollton'));
        $appUser = $this->createAppUser->create($brother, 'info@email.com', 'p455w0rd', 'it_IT');

        $this->assertSame($brother, $appUser->getBrother());
        $this->assertSame('info@email.com', $appUser->getEmail());
        $this->assertSame('3r34fQDEWw3d', $appUser->getPassword());
        $this->assertSame('it_IT', $appUser->getLocaleCode());
        $this->assertSame($this->appUserRepository->findAll()->first(), $appUser);
    }

    public function testThatItCreatesANewAppUserWithoutPasswordIfNotSpecified(): void
    {
        $brother = new Brother('John', 'Ritz', new Congregation('Carrollton'));
        $adminUser = $this->createAppUser->create($brother, 'info@email.com', null, 'it_IT');

        $this->assertSame('info@email.com', $adminUser->getEmail());
        $this->assertNull($adminUser->getPassword());
        $this->assertSame('it_IT', $adminUser->getLocaleCode());
        $this->assertSame($this->appUserRepository->findAll()->first(), $adminUser);
    }

    public function testThatItCreatesANewAppUserWithoutLocaleIfNotSpecified(): void
    {
        $brother = new Brother('John', 'Ritz', new Congregation('Carrollton'));
        $adminUser = $this->createAppUser->create($brother, 'info@email.com', 'p455w0rd', null);

        $this->assertSame('info@email.com', $adminUser->getEmail());
        $this->assertSame('3r34fQDEWw3d', $adminUser->getPassword());
        $this->assertNull($adminUser->getLocaleCode());
        $this->assertSame($this->appUserRepository->findAll()->first(), $adminUser);
    }
}
