<?php

namespace CongregationManager\Domain\User\Model;

class AdminUser extends User implements AdminUserInterface
{
    public static function create(string $email): AdminUserInterface
    {
        return new self($email);
    }
}
