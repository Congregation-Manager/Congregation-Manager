<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\TerritoryManager\Form\AreaFormType;
use CongregationManager\Bundle\TerritoryManager\Form\CreateTerritoryAssignmentType;
use CongregationManager\Bundle\TerritoryManager\Form\TerritoryFiltersFormType;
use CongregationManager\Bundle\TerritoryManager\Form\UpdateTerritoryAssignmentType;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_territory_manager.form.area', AreaFormType::class)
        ->args([service('congregation_manager_core.context.congregation'), service('doctrine')])
        ->tag('form.type')
    ;

    $services->set(
        'congregation_manager_territory_manager.form.create_territory_assignment',
        CreateTerritoryAssignmentType::class
    )
        ->tag('form.type')
    ;

    $services->set('congregation_manager_territory_manager.form.territory_filters', TerritoryFiltersFormType::class)
        ->tag('form.type')
    ;

    $services->set(
        'congregation_manager_territory_manager.form.update_territory_assignment',
        UpdateTerritoryAssignmentType::class
    )
        ->tag('form.type')
    ;
};
