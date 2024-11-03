<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->import('@CongregationManagerAdminBundle/config/routes.php')
        ->prefix('/%congregation_manager_admin.path_name%');
};
