<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Component\TerritoryManager\Domain\Generator\S13Generator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_territory_manager.generator.S13', S13Generator::class)
        ->args([service('congregation_manager_territory_manager.repository.territory')])
    ;
};
