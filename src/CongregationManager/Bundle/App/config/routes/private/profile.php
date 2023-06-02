<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('app_dashboard', '/dashboard')
        ->controller(['cm.controller.app_dashboard', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('app_profile_update', '/profile/update')
        ->controller(['cm.controller.app_profile', 'update'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('app_change_password', '/password/update')
        ->controller(['cm.controller.app_change_password', 'update'])
        ->methods(['GET', 'POST'])
    ;

};
