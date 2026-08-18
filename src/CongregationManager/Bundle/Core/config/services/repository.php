<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Repository\AdminResetPasswordRequestRepository;
use CongregationManager\Bundle\Core\Repository\AppResetPasswordRequestRepository;
use CongregationManager\Bundle\Core\Repository\TerritoryRepository;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(TerritoryRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;
    $services->alias('congregation_manager_territory_manager.repository.territory', TerritoryRepository::class);

    $services->set(AdminResetPasswordRequestRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;

    $services->set(AppResetPasswordRequestRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;
};
