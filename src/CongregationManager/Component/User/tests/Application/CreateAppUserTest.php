<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Tests\Application;

use CongregationManager\Component\Congregation\Domain\Brother;
use CongregationManager\Component\Congregation\Domain\Congregation;
use CongregationManager\Component\Core\Application\CreateAppUser;
use CongregationManager\Component\Core\Domain\Factory\AppUserFactory;
use CongregationManager\Component\Core\Infrastructure\InMemory\Repository\AppUserRepository;
use CongregationManager\Component\User\Infrastructure\InMemory\Hasher\UserPasswordHasher;
use CongregationManager\Contract\Resource\IncrementingIdGenerator;
use CongregationManager\Contract\Resource\IntegerAggregateRootId;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class CreateAppUserTest extends TestCase
{
    private AppUserRepository $appUserRepository;

    private CreateAppUser $createAppUser;

    private UserPasswordHasher $userPasswordHasher;

    #[\Override]
    protected function setUp(): void
    {
        $this->appUserRepository = new AppUserRepository();
        $this->userPasswordHasher = new UserPasswordHasher();
        $this->createAppUser = new CreateAppUser(
            new AppUserFactory(new IncrementingIdGenerator()),
            $this->appUserRepository,
            $this->userPasswordHasher
        );
    }

    public function testThatItCreatesANewAppUser(): void
    {
        $brother = new Brother(new IntegerAggregateRootId(1), 'John', 'Ritz', new Congregation(
            new IntegerAggregateRootId(2),
            'Carrollton'
        ));
        $appUser = $this->createAppUser->create($brother, 'info@email.com', 'p455w0rd', 'it_IT');

        $this->assertSame($brother, $appUser->getBrother());
        $this->assertSame('info@email.com', $appUser->getEmail());
        $this->assertSame(
            $this->userPasswordHasher->hashPasswordForUser('p455w0rd', $appUser),
            $appUser->getPassword()
        );
        $this->assertSame('it_IT', $appUser->getLocaleCode());
        $appUsers = $this->appUserRepository->appUsers;
        $this->assertSame(reset($appUsers), $appUser);
    }

    public function testThatItCreatesANewAppUserWithoutPasswordIfNotSpecified(): void
    {
        $brother = new Brother(new IntegerAggregateRootId(3), 'John', 'Ritz', new Congregation(
            new IntegerAggregateRootId(4),
            'Carrollton'
        ));
        $appUser = $this->createAppUser->create($brother, 'info@email.com', null, 'it_IT');

        $this->assertSame('info@email.com', $appUser->getEmail());
        $this->assertNull($appUser->getPassword());
        $this->assertSame('it_IT', $appUser->getLocaleCode());
        $appUsers = $this->appUserRepository->appUsers;
        $this->assertSame(reset($appUsers), $appUser);
    }

    public function testThatItCreatesANewAppUserWithoutLocaleIfNotSpecified(): void
    {
        $brother = new Brother(new IntegerAggregateRootId(5), 'John', 'Ritz', new Congregation(
            new IntegerAggregateRootId(6),
            'Carrollton'
        ));
        $appUser = $this->createAppUser->create($brother, 'info@email.com', 'p455w0rd', null);

        $this->assertSame('info@email.com', $appUser->getEmail());
        $this->assertSame(
            $this->userPasswordHasher->hashPasswordForUser('p455w0rd', $appUser),
            $appUser->getPassword()
        );
        $this->assertNull($appUser->getLocaleCode());
        $appUsers = $this->appUserRepository->appUsers;
        $this->assertSame(reset($appUsers), $appUser);
    }
}
