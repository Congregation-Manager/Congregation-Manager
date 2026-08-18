<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Utils\Validator;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use function Symfony\Component\String\u;

final class Validator
{
    public function validateString(mixed $string): string
    {
        if (!is_string($string) || $string === '') {
            throw new InvalidArgumentException('The string can not be empty.');
        }

        return $string;
    }

    public function validatePassword(mixed $plainPassword): string
    {
        $plainPassword = $this->validateString($plainPassword);

        if (u($plainPassword)->trim()->length() < 8) {
            throw new InvalidArgumentException('The password must be at least 8 characters long.');
        }

        return $plainPassword;
    }

    public function validateEmail(mixed $email): string
    {
        $email = $this->validateString($email);

        if (u($email)->indexOf('@') === null) {
            throw new InvalidArgumentException('The email should look like a real email.');
        }

        return $email;
    }
}
