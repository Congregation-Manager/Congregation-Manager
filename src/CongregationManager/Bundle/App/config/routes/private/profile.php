<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('app_dashboard', '/dashboard')
        ->controller(['congregation_manager_app.controller.dashboard', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('app_profile_update', '/profile/update')
        ->controller(['congregation_manager_app.controller.profile', 'update'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('app_change_password', '/password/update')
        ->controller(['congregation_manager_app.controller.change_password', 'update'])
        ->methods(['GET', 'POST'])
    ;
};
