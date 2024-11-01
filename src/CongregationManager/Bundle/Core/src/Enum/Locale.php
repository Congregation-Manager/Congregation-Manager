<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Enum;

enum Locale: string
{
    case English = 'en';

    case Italian = 'it';

    public static function getDefault(): self
    {
        return self::English;
    }
}
