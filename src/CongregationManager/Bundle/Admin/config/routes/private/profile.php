<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('admin_dashboard', '/dashboard')
        ->controller(['congregation_manager_admin.controller.dashboard', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('admin_profile_update', '/profile/update')
        ->controller(['congregation_manager_admin.controller.profile', 'update'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('admin_change_password', '/password/update')
        ->controller(['congregation_manager_admin.controller.change_password', 'update'])
        ->methods(['GET', 'POST'])
    ;
};
