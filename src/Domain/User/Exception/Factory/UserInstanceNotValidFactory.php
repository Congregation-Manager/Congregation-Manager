<?php


namespace App\Domain\User\Exception\Factory;

use App\Domain\User\Exception\UserInstanceNotValid;
use App\Domain\User\Model\AdminUserInterface;
use App\Domain\User\Model\AppUserInterface;

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
