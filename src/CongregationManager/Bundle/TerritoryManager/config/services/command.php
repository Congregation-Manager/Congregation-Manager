<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Component\TerritoryManager\Application\Command\CreateTerritoryAssignmentHandler;
use CongregationManager\Component\TerritoryManager\Application\Command\UpdateTerritoryAssignmentHandler;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set(
        'congregation_manager_territory_manager.command_handler.create_territory_assignment',
        CreateTerritoryAssignmentHandler::class
    )
        ->args([
            service('congregation_manager_territory_manager.factory.territory_assignment'),
            service('congregation_manager_territory_manager.repository.territory_assignment'),
        ])
    ;

    $services->set(
        'congregation_manager_territory_manager.command_handler.update_territory_assignment',
        UpdateTerritoryAssignmentHandler::class
    )
        ->args([service('congregation_manager_territory_manager.repository.territory_assignment')])
    ;
};
