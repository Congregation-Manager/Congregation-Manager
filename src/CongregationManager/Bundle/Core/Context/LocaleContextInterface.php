<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Context;

interface LocaleContextInterface
{
    public function getLocaleCode(): string;
}
