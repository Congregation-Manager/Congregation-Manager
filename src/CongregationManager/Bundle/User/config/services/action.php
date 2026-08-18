<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Component\Core\Application\CreateAdminUser;
use CongregationManager\Component\Core\Application\CreateAppUser;
use CongregationManager\Component\Core\Application\CreateAppUserInvitation;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_user.create_admin_user', CreateAdminUser::class)
        ->args([
            service('congregation_manager_user.factory.admin_user'),
            service('congregation_manager_user.repository.admin_user'),
            service('congregation_manager_user.hasher.user_password'),
        ])
    ;

    $services->set('congregation_manager_user.create_app_user', CreateAppUser::class)
        ->args([
            service('congregation_manager_user.factory.app_user'),
            service('congregation_manager_user.repository.app_user'),
            service('congregation_manager_user.hasher.user_password'),
        ])
    ;

    $services->set('congregation_manager_user.create.app_user_invitation', CreateAppUserInvitation::class)
        ->args([
            service('congregation_manager_user.generator.token'),
            service('congregation_manager_user.repository.app_user_invitation'),
        ])
    ;
};
