<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('admin_brother_index', '/brothers')
        ->controller(['cm.controller.admin_brother', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('admin_brother_show', '/brother/{id}')
        ->controller(['cm.controller.admin_brother', 'show'])
        ->methods(['GET'])
    ;

    $routes->add('admin_invite_app_user', '/brother/{id}/invite')
        ->controller(['cm.controller.admin_brother', 'invite'])
        ->methods(['GET', 'POST'])
    ;
};
