<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Context;

interface LocaleContextInterface
{
    /**
     * @throws LocaleNotFoundException
     */
    public function getLocaleCode(): string;
}
