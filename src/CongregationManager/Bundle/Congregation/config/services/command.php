<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Congregation\Command\CreateCongregationCommand;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_congregation.command.create_congregation', CreateCongregationCommand::class)
        ->args([
            service('congregation_manager_congregation.create_congregation'),
            service('doctrine.orm.entity_manager'),
            'app:create-congregation',
        ])
        ->tag('console.command')
    ;
};
