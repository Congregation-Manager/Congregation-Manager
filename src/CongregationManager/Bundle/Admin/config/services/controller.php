<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Admin\Controller\AdminBrotherController;
use CongregationManager\Bundle\Admin\Controller\AdminChangePasswordController;
use CongregationManager\Bundle\Admin\Controller\AdminCongregationController;
use CongregationManager\Bundle\Admin\Controller\AdminDashboardController;
use CongregationManager\Bundle\Admin\Controller\AdminLocaleController;
use CongregationManager\Bundle\Admin\Controller\AdminProfileController;
use CongregationManager\Bundle\Admin\Controller\AdminUserLoginController;
use CongregationManager\Bundle\Admin\Controller\ResetAdminPasswordController;
use CongregationManager\Bundle\Admin\Controller\ThemeController;
use Psr\Container\ContainerInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_admin.controller.brother', AdminBrotherController::class)
        ->args([
            service('congregation_manager_congregation.repository.brother'),
            service('congregation_manager_user.create.app_user_invitation'),
            service('doctrine.orm.entity_manager'),
            service('congregation_manager_admin.notificator.message'),
            service('translator'),
        ])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_admin.controller.change_password', AdminChangePasswordController::class)
        ->args([
            service('security.helper'),
            service('doctrine.orm.entity_manager'),
            service('translator'),
            service('congregation_manager_user.hasher.user_password'),
        ])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_admin.controller.congregation', AdminCongregationController::class)
        ->args([service('congregation_manager_congregation.repository.congregation')])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_admin.controller.dashboard', AdminDashboardController::class)
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_admin.controller.locale', AdminLocaleController::class)
        ->args([
            param('congregation_manager_core.available_locales'),
            service('request_stack'),
            service('security.helper'),
            service('doctrine.orm.entity_manager'),
        ])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_admin.controller.profile', AdminProfileController::class)
        ->args([service('security.helper'), service('doctrine.orm.entity_manager'), service('translator')])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_admin.controller.login', AdminUserLoginController::class)
        ->args([service('security.authentication_utils')])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_admin.controller.reset_password', ResetAdminPasswordController::class)
        ->args([
            service('symfonycasts.reset_password.helper'),
            service('doctrine.orm.entity_manager'),
            service('security.user_password_hasher'),
            service('logger'),
            service('congregation_manager_admin.notificator.message'),
            service('translator'),
        ])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_admin.controller.theme', ThemeController::class)
        ->args([
            service('congregation_manager_core.context.theme'),
            service('request_stack'),
            service('security.helper'),
        ])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;
};
