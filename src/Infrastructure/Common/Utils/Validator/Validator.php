<?php


namespace CongregationManager\Infrastructure\Common\Utils\Validator;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use function Symfony\Component\String\u;

final class Validator
{
    public function validatePassword(?string $plainPassword): string
    {
        if (empty($plainPassword)) {
            throw new InvalidArgumentException('The password can not be empty.');
        }

        if (u($plainPassword)->trim()->length() < 8) {
            throw new InvalidArgumentException('The password must be at least 8 characters long.');
        }

        return $plainPassword;
    }

    public function validateEmail(?string $email): string
    {
        if (empty($email)) {
            throw new InvalidArgumentException('The email can not be empty.');
        }

        if (null === u($email)->indexOf('@')) {
            throw new InvalidArgumentException('The email should look like a real email.');
        }

        return $email;
    }
}
