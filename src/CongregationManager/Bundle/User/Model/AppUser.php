<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Model;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\User\Domain\AppUser as DomainAppUser;

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
