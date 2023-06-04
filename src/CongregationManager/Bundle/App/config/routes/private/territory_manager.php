<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('app_territory_index', '/territories')
        ->controller(['congregation_manager_app.controller.territory', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('app_territory_s_13', '/territories/S-13')
        ->controller(['congregation_manager_app.controller.territory', 's13'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('app_territory_show', '/territory/{id}')
        ->controller(['congregation_manager_app.controller.territory', 'show'])
        ->methods(['GET'])
    ;

    $routes->add('app_territory_assignment_create', '/territory-assignment/create')
        ->controller(['congregation_manager_app.controller.territory_assignment', 'create'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('app_territory_assignment_update', '/territory-assignment/{id}/update')
        ->controller(['congregation_manager_app.controller.territory_assignment', 'update'])
        ->methods(['GET', 'POST'])
    ;
};
