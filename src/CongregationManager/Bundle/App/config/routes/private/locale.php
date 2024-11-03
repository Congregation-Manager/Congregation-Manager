<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add('congregation_maanger_app_switch_locale', '/switch-locale/{locale}')
        ->controller(['congregation_manager_app.controller.locale', 'switchLocale'])
        ->defaults([
            'locale' => '%congregation_manager_core.available_locales_regex%',
        ])
        ->methods(['GET'])
    ;
};
