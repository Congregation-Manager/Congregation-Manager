<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\User\Action\CreateAdminUser;
use CongregationManager\Bundle\User\Action\CreateAppUser;
use CongregationManager\Bundle\User\Action\CreateAppUserInvitation;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_user.create_admin_user', CreateAdminUser::class)
        ->args([
            service('congregation_manager_user.repository.admin_user'),
            service('congregation_manager_user.hasher.user_password'),
        ])
    ;

    $services->set('congregation_manager_user.create_app_user', CreateAppUser::class)
        ->args([
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
