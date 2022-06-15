<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Context;

interface LocaleContextInterface
{
    public function getLocaleCode(): string;
}
