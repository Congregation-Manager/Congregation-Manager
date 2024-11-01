<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\User\Command\CreateAdminUserCommand;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_user.command.craete_admin_user', CreateAdminUserCommand::class)
        ->args([
            service('congregation_manager_user.create_admin_user'),
            service('doctrine.orm.entity_manager'),
            service('congregation_manager_user.validator'),
            param('default_locale'),
            param('supported_locales'),
            'app:create-admin-user',
        ])
        ->tag('console.command')
    ;
};
