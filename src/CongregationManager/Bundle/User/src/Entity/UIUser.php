<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Entity;

use CongregationManager\Component\User\Domain\UIUser as DomainUIUser;

class UIUser extends DomainUIUser implements UIUserInterface
{
    use SymfonyUserTrait;

    /**
     * @var string[]
     */
    protected array $roles = ['ROLE_USER'];
}
