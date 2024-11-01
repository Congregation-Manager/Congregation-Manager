<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Enum\Locale;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->parameters()
        ->set('congregation_manager_core.default_locale', Locale::getDefault()->value)
        ->set(
            'congregation_manager_core.available_locales',
            array_map(static fn (Locale $locale): string => $locale->value, Locale::cases())
        )
        ->set(
            'congregation_manager_core.available_locales_regex',
            implode('|', array_map(static fn (Locale $locale): string => $locale->value, Locale::cases()))
        )
    ;

    $containerConfigurator->import('@CongregationManagerCongregationBundle/config/config.php');
    $containerConfigurator->import('@CongregationManagerResourceBundle/config/config.php');
    $containerConfigurator->import('@CongregationManagerTerritoryManagerBundle/config/config.php');
    $containerConfigurator->import('@CongregationManagerUserBundle/config/config.php');
    $containerConfigurator->import('packages/*.php');
};
