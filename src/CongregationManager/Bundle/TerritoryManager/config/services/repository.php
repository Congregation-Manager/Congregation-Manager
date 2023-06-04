<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\TerritoryManager\Repository\AreaRepository;
use CongregationManager\Bundle\TerritoryManager\Repository\MunicipalityRepository;
use CongregationManager\Bundle\TerritoryManager\Repository\ProvinceRepository;
use CongregationManager\Bundle\TerritoryManager\Repository\TerritoryAssignmentRepository;
use CongregationManager\Bundle\TerritoryManager\Repository\TerritoryRepository;
use CongregationManager\Component\TerritoryManager\Infrastructure\Repository\InMemory\TerritoryRepository as InMemoryTerritoryRepository;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->alias('congregation_manager_territory_manager.repository.area', AreaRepository::class);
    $services->set(AreaRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;

    $services->set('congregation_manager_territory_manager.repository.municipality', MunicipalityRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;

    $services->set('congregation_manager_territory_manager.repository.province', ProvinceRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;

    $services->set(
        'congregation_manager_territory_manager.repository.territory_assignment',
        TerritoryAssignmentRepository::class
    )
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;

    $services->set('congregation_manager_territory_manager.repository.territory', TerritoryRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;

    $services->set(
        'congregation_manager_territory_manager.in_memory_repository.territory',
        InMemoryTerritoryRepository::class
    );
};
