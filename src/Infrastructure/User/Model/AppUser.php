<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\User\Model\AppUser as DomainAppUser;

class AppUser extends DomainAppUser implements AppUserInterface
{
    use SymfonyUserTrait;

    /**
     * @var string[]
     */
    protected array $roles = ['ROLE_USER'];

    public static function create(BrotherInterface $brother, string $email): AppUserInterface
    {
        return new self($brother, $email);
    }
}
