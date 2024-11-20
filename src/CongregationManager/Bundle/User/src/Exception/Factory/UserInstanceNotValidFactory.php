<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Exception\Factory;

use CongregationManager\Bundle\User\Exception\UserInstanceNotValid;
use CongregationManager\Component\Core\Domain\AdminUserInterface;
use CongregationManager\Component\Core\Domain\AppUserInterface;

final class UserInstanceNotValidFactory
{
    public static function createWithInstanceClass(string $instanceClass): UserInstanceNotValid
    {
        return new UserInstanceNotValid(sprintf(
            'User instance not valid. Provided "%s", expected "%s"',
            $instanceClass,
            implode(', ', [AppUserInterface::class, AdminUserInterface::class])
        ));
    }
}
