<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Tests\Application;

use CongregationManager\Component\Congregation\Domain\Brother;
use CongregationManager\Component\Congregation\Domain\Congregation;
use CongregationManager\Component\User\Application\CreateAppUser;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;
use CongregationManager\Component\User\Domain\Repository\AppUserRepositoryInterface;
use CongregationManager\Component\User\Domain\UserInterface;
use CongregationManager\Component\User\Infrastructure\InMemory\Repository\AppUserRepository;
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
        $appUsers = $this->appUserRepository->appUsers;
        $this->assertSame(reset($appUsers), $appUser);
    }

    public function testThatItCreatesANewAppUserWithoutPasswordIfNotSpecified(): void
    {
        $brother = new Brother('John', 'Ritz', new Congregation('Carrollton'));
        $appUser = $this->createAppUser->create($brother, 'info@email.com', null, 'it_IT');

        $this->assertSame('info@email.com', $appUser->getEmail());
        $this->assertNull($appUser->getPassword());
        $this->assertSame('it_IT', $appUser->getLocaleCode());
        $appUsers = $this->appUserRepository->appUsers;
        $this->assertSame(reset($appUsers), $appUser);
    }

    public function testThatItCreatesANewAppUserWithoutLocaleIfNotSpecified(): void
    {
        $brother = new Brother('John', 'Ritz', new Congregation('Carrollton'));
        $appUser = $this->createAppUser->create($brother, 'info@email.com', 'p455w0rd', null);

        $this->assertSame('info@email.com', $appUser->getEmail());
        $this->assertSame('3r34fQDEWw3d', $appUser->getPassword());
        $this->assertNull($appUser->getLocaleCode());
        $appUsers = $this->appUserRepository->appUsers;
        $this->assertSame(reset($appUsers), $appUser);
    }
}
