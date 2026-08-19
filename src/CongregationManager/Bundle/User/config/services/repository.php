<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\User\Repository\AdminUserRepository;
use CongregationManager\Bundle\User\Repository\AppUserInvitationRepository;
use CongregationManager\Bundle\User\Repository\AppUserRepository;
use CongregationManager\Bundle\User\Repository\ResetPasswordRequestRepository;
use CongregationManager\Component\Core\Infrastructure\InMemory\Repository\AdminUserRepository as InMemoryAdminUserRepository;
use CongregationManager\Component\Core\Infrastructure\InMemory\Repository\AppUserRepository as InMemoryAppUserRepository;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->alias('congregation_manager_user.repository.admin_user', AdminUserRepository::class);
    $services->set(AdminUserRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;

    $services->set('congregation_manager_user.repository.app_user_invitation', AppUserInvitationRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;

    $services->alias('congregation_manager_user.repository.app_user', AppUserRepository::class);
    $services->set(AppUserRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;

    $services->set('congregation_manager_user.repository.reset_password_request', ResetPasswordRequestRepository::class)
        ->public()
        ->args([service('doctrine.orm.entity_manager'), service('congregation_manager_resource.generator.id')])
    ;

    $services->set('congregation_manager_user.in_memory_repository.admin_user', InMemoryAdminUserRepository::class);

    $services->set('congregation_manager_user.in_memory_repository.app_user', InMemoryAppUserRepository::class);
};
