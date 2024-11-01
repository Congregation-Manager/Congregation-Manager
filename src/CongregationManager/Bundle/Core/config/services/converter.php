<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Converter\LocaleConverter;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire(false)
        ->autoconfigure(false)
    ;

    $services->set('congregation_manager_core.converter.locale', LocaleConverter::class)
        ->arg('$defaultLocale', (string) param('default_locale'))
    ;
};
