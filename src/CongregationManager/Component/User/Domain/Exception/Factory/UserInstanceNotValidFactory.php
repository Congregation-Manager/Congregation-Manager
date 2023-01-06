<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain\Exception\Factory;

use CongregationManager\Component\User\Domain\AdminUserInterface;
use CongregationManager\Component\User\Domain\AppUserInterface;
use CongregationManager\Component\User\Domain\Exception\UserInstanceNotValid;

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
