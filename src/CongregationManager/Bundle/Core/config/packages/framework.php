<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $frameworkConfig): void {
    $frameworkConfig
        ->defaultLocale(\CongregationManager\Bundle\Core\Enum\Locale::getDefault()->value)
        ->enabledLocales(
            array_map(
                static fn (\CongregationManager\Bundle\Core\Enum\Locale $locale): string => $locale->value,
                \CongregationManager\Bundle\Core\Enum\Locale::cases()
            )
        )
        ->translator([
            'fallbacks' => [\CongregationManager\Bundle\Core\Enum\Locale::getDefault()->value],
        ])
    ;
};
