<?php

namespace CongregationManager\Tests\Behat\Services;

use Symfony\Component\Security\Core\User\UserInterface;

interface SecurityServiceInterface
{
    public function logIn(UserInterface $user): void;
}
