<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Command\ImportFromOldCMCommand;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_core.command.import_from_old_cm', ImportFromOldCMCommand::class)
        ->args([
            service('congregation_manager_core.old_cm.repository.congregation'),
            service('congregation_manager_cqrs.messenger_command_bus'),
            service('congregation_manager_core.old_cm.repository.brother'),
            service('congregation_manager_congregation.create_brother'),
            service('congregation_manager_core.old_cm.repository.app_user'),
            service('congregation_manager_user.create_app_user'),
            service('congregation_manager_core.old_cm.repository.province'),
            service('congregation_manager_territory_manager.command_handler.create_province'),
            service('congregation_manager_core.old_cm.repository.municipality'),
            service('congregation_manager_territory_manager.command_handler.create_municipality'),
            service('congregation_manager_core.old_cm.repository.area'),
            service('congregation_manager_territory_manager.command_handler.create_area'),
            service('congregation_manager_core.old_cm.repository.territory'),
            service('congregation_manager_territory_manager.command_handler.create_territory'),
            service('congregation_manager_core.old_cm.repository.territory_assignment'),
            service('congregation_manager_territory_manager.command.create_territory_assignment'),
            'app:import-from-old-cm',
        ])
        ->tag('console.command')
    ;
};
