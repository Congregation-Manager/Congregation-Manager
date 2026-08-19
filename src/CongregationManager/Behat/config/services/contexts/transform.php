<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Behat\Context\Transform\BrotherContext;
use CongregationManager\Behat\Context\Transform\TerritoryAssignmentContext;
use CongregationManager\Behat\Context\Transform\TerritoryContext;
use CongregationManager\Behat\Context\Transform\UserContext;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->public();

    $services->set('congregation_manager_behat.context.transform.user', UserContext::class)
        ->args([service('congregation_manager_resource.generator.id'), service('doctrine.orm.entity_manager')])
    ;

    $services->set('congregation_manager_behat.context.transform.brother', BrotherContext::class)
        ->args([service('congregation_manager_congregation.repository.brother')])
    ;

    $services->set('congregation_manager_behat.context.transform.territory', TerritoryContext::class)
        ->args([service('congregation_manager_territory_manager.repository.territory')])
    ;

    $services->set(
        'congregation_manager_behat.context.transform.territory_assignment',
        TerritoryAssignmentContext::class
    )
        ->args([
            service('congregation_manager_territory_manager.repository.territory_assignment'),
            service('congregation_manager_territory_manager.repository.territory'),
            service('congregation_manager_congregation.repository.brother'),
        ])
    ;
};
