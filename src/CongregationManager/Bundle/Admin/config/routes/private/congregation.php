<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('admin_congregation_index', '/congregations')
        ->controller(['cm.controller.admin_congregation', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('admin_congregation_show', '/congregation/{id}')
        ->controller(['cm.controller.admin_congregation', 'show'])
        ->methods(['GET'])
    ;
};
