<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add('congregation_manager_app_entrypoint', '/')
        ->controller(['congregation_manager_app.controller.entrypoint', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('congregation_manager_app_homepage', '/{_locale}')
        ->controller(['congregation_manager_app.controller.homepage', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('congregation_manager_app_login', '/{_locale}/login')
        ->controller(['congregation_manager_app.controller.login', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('congregation_manager_app_login_check', '/{_locale}/login-check')
        ->methods(['POST'])
    ;

    $routes->add('congregation_manager_app_logout', '/{_locale}/logout')
        ->methods(['GET'])
    ;

    $routes->add('congregation_manager_app_forgot_password_request', '/{_locale}/reset-password')
        ->controller(['congregation_manager_app.controller.reset_password', 'request'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('congregation_manager_app_check_email', '/{_locale}/reset-password/check-email')
        ->controller(['congregation_manager_app.controller.reset_password', 'checkEmail'])
        ->methods(['GET'])
    ;

    $routes->add('congregation_manager_app_reset_password', '/{_locale}/reset-password/reset/{token}')
        ->controller(['congregation_manager_app.controller.reset_password', 'reset'])
        ->defaults([
            'token' => null,
        ])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('congregation_manager_app_complete_account', '/complete/account/{token}')
        ->controller(['congregation_manager_app.controller.complete_account', 'complete'])
        ->methods(['GET'])
    ;

    $routes->add('congregation_manager_app_complete_account_localized', '/{_locale}/complete/account')
        ->controller(['congregation_manager_app.controller.complete_account', 'complete'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('congregation_manager_app_switch_theme', '/switch-theme/{theme}')
        ->controller(['congregation_manager_app.controller.theme', 'switchTheme'])
        ->defaults([
            'theme' => null,
        ])
        ->methods(['GET'])
    ;
};
