<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Entity;

use CongregationManager\Component\User\Domain\User as DomainUser;
use CongregationManager\Component\User\Domain\UserInterface;

class User extends DomainUser implements UserInterface
{
}
