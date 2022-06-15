<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Services\Setter;

use Behat\Mink\Session;

final class CookieSetter implements CookieSetterInterface
{
    public function __construct(
        private Session $minkSession
    ) {
    }

    public function setCookie(string $name, string $value): void
    {
        $this->minkSession->setCookie($name, $value);
    }
}
