<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\TerritoryManager\Validator\ValidTerritoryAssignmentsValidator;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set(
        'congregation_manager_territory_manager.validator.valid_territory_assignments',
        ValidTerritoryAssignmentsValidator::class
    )
        ->tag('validator.constraint_validator')
    ;
};
