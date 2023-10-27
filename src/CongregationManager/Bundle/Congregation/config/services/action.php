<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Component\Congregation\Application\CreateBrother;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_congregation.create_brother', CreateBrother::class)
        ->args([service('congregation_manager_congregation.repository.brother')])
    ;
};
