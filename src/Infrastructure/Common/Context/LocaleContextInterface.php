<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Context;

interface LocaleContextInterface
{
    /**
     * @throws LocaleNotFoundException
     */
    public function getLocaleCode(): string;
}
