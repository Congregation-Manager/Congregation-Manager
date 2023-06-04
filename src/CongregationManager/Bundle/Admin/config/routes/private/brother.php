<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('admin_brother_index', '/brothers')
        ->controller(['congregation_manager_admin.controller.brother', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('admin_brother_show', '/brother/{id}')
        ->controller(['congregation_manager_admin.controller.brother', 'show'])
        ->methods(['GET'])
    ;

    $routes->add('admin_invite_app_user', '/brother/{id}/invite')
        ->controller(['congregation_manager_admin.controller.brother', 'invite'])
        ->methods(['GET', 'POST'])
    ;
};
