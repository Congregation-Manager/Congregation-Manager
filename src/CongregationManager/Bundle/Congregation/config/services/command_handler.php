<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Component\Congregation\Application\Command\CreateCongregation\CreateCongregationHandler;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_congregation.command_handler.add_congregation', CreateCongregationHandler::class)
        ->args([
            service('congregation_manager_congregation.persister.congregation'),
            service('congregation_manager_congregation.factory.congregation'),
        ])
    ;
};
