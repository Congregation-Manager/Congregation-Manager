<?php

namespace CongregationManager\Domain\User\Model;

class AppUser extends User implements AppUserInterface
{
    public static function create(string $email): AppUserInterface
    {
        return new self($email);
    }
}
