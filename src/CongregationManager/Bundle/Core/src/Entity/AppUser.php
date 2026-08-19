<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Entity;

use CongregationManager\Bundle\User\Entity\SymfonyUserTrait;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Core\Domain\AppUser as DomainAppUser;
use CongregationManager\Contract\Resource\AggregateRootId;

class AppUser extends DomainAppUser implements AppUIUserInterface
{
    use SymfonyUserTrait;

    /**
     * @var string[]
     */
    protected array $roles = ['ROLE_USER'];

    public static function create(
        AggregateRootId $id,
        BrotherInterface $brother,
        string $email
    ): AppUIUserInterface {
        return new self($id, $brother, $email);
    }
}
