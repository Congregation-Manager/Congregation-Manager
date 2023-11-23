<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Component\TerritoryManager\Domain\Factory\TerritoryAssignmentFactory;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set(
        'congregation_manager_territory_manager.factory.territory_assignment',
        TerritoryAssignmentFactory::class
    )->args([service('congregation_manager_resource.generator.uuidv4')]);
};
