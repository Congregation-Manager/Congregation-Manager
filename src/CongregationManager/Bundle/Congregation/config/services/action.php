<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Component\Congregation\Application\CreateBrother;
use CongregationManager\Component\Congregation\Application\CreateCongregation;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_congregation.create_brother', CreateBrother::class)
        ->args([service('congregation_manager_congregation.repository.brother')])
    ;

    $services->set('congregation_manager_congregation.create_congregation', CreateCongregation::class)
        ->args([
            service('congregation_manager_congregation.factory.congregation'),
            service('congregation_manager_congregation.repository.congregation'),
        ])
    ;
};
