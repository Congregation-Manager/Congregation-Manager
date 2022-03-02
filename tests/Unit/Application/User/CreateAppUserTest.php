<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Application\User;

use CongregationManager\Application\User\CreateAppUser;
use CongregationManager\Domain\Congregation\Model\Brother;
use CongregationManager\Domain\Congregation\Model\Congregation;
use CongregationManager\Domain\User\Repository\AppUserRepositoryInterface;
use CongregationManager\Tests\Repository\AppUserRepository;
use PHPUnit\Framework\TestCase;

class CreateAppUserTest extends TestCase
{
    private AppUserRepositoryInterface $appUserRepository;

    private CreateAppUser $createAppUser;

    protected function setUp(): void
    {
        $this->appUserRepository = new AppUserRepository();
        $this->createAppUser = new CreateAppUser($this->appUserRepository);
    }

    public function test_that_it_creates_a_new_app_user(): void
    {
        $brother = new Brother('John', 'Ritz', new Congregation('Carrollton'));
        $appUser = $this->createAppUser->create($brother, 'info@email.com', 'p455w0rd', 'it_IT');

        $this->assertEquals($brother, $appUser->getBrother());
        $this->assertEquals('info@email.com', $appUser->getEmail());
        $this->assertEquals('p455w0rd', $appUser->getPassword());
        $this->assertEquals('it_IT', $appUser->getLocaleCode());
        $this->assertEquals($this->appUserRepository->findAll()->first(), $appUser);
    }
}
