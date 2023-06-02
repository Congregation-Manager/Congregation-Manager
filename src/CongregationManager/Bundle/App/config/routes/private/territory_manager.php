<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('app_territory_index', '/territories')
        ->controller(['cm.controller.app_territory', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('app_territory_s_13', '/territories/S-13')
        ->controller(['cm.controller.app_territory', 's13'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('app_territory_show', '/territory/{id}')
        ->controller(['cm.controller.app_territory', 'show'])
        ->methods(['GET'])
    ;

    $routes->add('app_territory_assignment_create', '/territory-assignment/create')
        ->controller(['cm.controller.app_territory_assignment', 'create'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('app_territory_assignment_update', '/territory-assignment/{id}/update')
        ->controller(['cm.controller.app_territory_assignment', 'update'])
        ->methods(['GET', 'POST'])
    ;
};
