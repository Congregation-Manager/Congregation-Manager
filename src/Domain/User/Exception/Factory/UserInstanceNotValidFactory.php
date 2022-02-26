<?php


namespace CongregationManager\Domain\User\Exception\Factory;

use CongregationManager\Domain\User\Exception\UserInstanceNotValid;
use CongregationManager\Domain\User\Model\AdminUserInterface;
use CongregationManager\Domain\User\Model\AppUserInterface;

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
