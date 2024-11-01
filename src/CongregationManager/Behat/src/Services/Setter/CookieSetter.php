<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Services\Setter;

use Behat\Mink\Session;

final readonly class CookieSetter implements CookieSetterInterface
{
    public function __construct(
        private Session $minkSession
    ) {
    }

    #[\Override]
    public function setCookie(string $name, string $value): void
    {
        $this->minkSession->setCookie($name, $value);
    }
}
