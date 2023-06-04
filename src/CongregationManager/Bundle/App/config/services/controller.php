<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\App\Controller\AppChangePasswordController;
use CongregationManager\Bundle\App\Controller\AppCompleteAccountController;
use CongregationManager\Bundle\App\Controller\AppDashboardController;
use CongregationManager\Bundle\App\Controller\AppLocaleController;
use CongregationManager\Bundle\App\Controller\AppProfileController;
use CongregationManager\Bundle\App\Controller\AppUserLoginController;
use CongregationManager\Bundle\App\Controller\HomePageController;
use CongregationManager\Bundle\App\Controller\ResetAppPasswordController;
use CongregationManager\Bundle\App\Controller\TerritoryAssignmentController;
use CongregationManager\Bundle\App\Controller\TerritoryController;
use Psr\Container\ContainerInterface;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_app.controller.change_password', AppChangePasswordController::class)
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

    $services->set('congregation_manager_app.controller.complete_account', AppCompleteAccountController::class)
        ->args([
            service('request_stack'),
            service('congregation_manager_user.repository.app_user_invitation'),
            service('congregation_manager_user.create_app_user'),
            service('doctrine.orm.entity_manager'),
        ])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_app.controller.dashboard', AppDashboardController::class)
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_app.controller.locale', AppLocaleController::class)
        ->args([
            param('supported_locales'),
            service('request_stack'),
            service('security.helper'),
            service('doctrine.orm.entity_manager'),
        ])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_app.controller.profile', AppProfileController::class)
        ->args([service('security.helper'), service('doctrine.orm.entity_manager'), service('translator')])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_app.controller.login', AppUserLoginController::class)
        ->args([service('security.authentication_utils')])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_app.controller.homepage', HomePageController::class)
        ->args([param('supported_locales')])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_app.controller.reset_password', ResetAppPasswordController::class)
        ->args([
            service('symfonycasts.reset_password.helper'),
            service('doctrine.orm.entity_manager'),
            service('mailer'),
            service('security.user_password_hasher'),
            service('logger'),
        ])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_app.controller.territory_assignment', TerritoryAssignmentController::class)
        ->args([
            service('congregation_manager_territory_manager.repository.territory'),
            service('congregation_manager_territory_manager.repository.territory_assignment'),
            service('congregation_manager_territory_manager.command_handler.create_territory_assignment'),
            service('congregation_manager_territory_manager.command_handler.update_territory_assignment'),
        ])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;

    $services->set('congregation_manager_app.controller.territory', TerritoryController::class)
        ->args([
            service('congregation_manager_territory_manager.repository.territory'),
            service('knp_paginator'),
            service('congregation_manager_territory_manager.generator.S13'),
            service('congregation_manager_core.context.congregation'),
            service('congregation_manager_territory_manager.renderer.word_S13'),
        ])
        ->call('setContainer', [service(ContainerInterface::class)])
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
    ;
};
