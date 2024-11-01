<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Component\TerritoryManager\Application\Command\CreateTerritoryAssignmentHandler;
use CongregationManager\Component\TerritoryManager\Application\Command\UpdateTerritoryAssignmentHandler;
use CongregationManager\Component\TerritoryManager\Application\CreateArea;
use CongregationManager\Component\TerritoryManager\Application\CreateMunicipality;
use CongregationManager\Component\TerritoryManager\Application\CreateProvince;
use CongregationManager\Component\TerritoryManager\Application\CreateTerritory;
use CongregationManager\Component\TerritoryManager\Application\CreateTerritoryAssignment;

return static function (ContainerConfigurator $containerConfigurator): void {
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

    $services->set('congregation_manager_territory_manager.command_handler.create_area', CreateArea::class)
        ->args([service('congregation_manager_territory_manager.repository.area')])
    ;

    $services->set(
        'congregation_manager_territory_manager.command_handler.create_municipality',
        CreateMunicipality::class
    )
        ->args([service('congregation_manager_territory_manager.repository.municipality')])
    ;

    $services->set('congregation_manager_territory_manager.command_handler.create_province', CreateProvince::class)
        ->args([service('congregation_manager_territory_manager.repository.province')])
    ;

    $services->set('congregation_manager_territory_manager.command_handler.create_territory', CreateTerritory::class)
        ->args([service('congregation_manager_territory_manager.repository.territory')])
    ;

    $services->set(
        'congregation_manager_territory_manager.command.create_territory_assignment',
        CreateTerritoryAssignment::class
    )
        ->args([service('congregation_manager_territory_manager.repository.territory_assignment')])
    ;
};
