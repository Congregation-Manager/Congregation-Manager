<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('app_homepage', '/')
        ->controller(['congregation_manager_app.controller.homepage', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('app_switch_locale', '/switch-locale/{locale}')
        ->controller(['congregation_manager_app.controller.locale', 'switchLocale'])
        ->defaults([
            'locale' => '%supported_locales%',
        ])
        ->methods(['GET'])
    ;

    $routes->add('app_login', '/login')
        ->controller(['congregation_manager_app.controller.login', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('app_login_check', '/login-check')
        ->methods(['POST'])
    ;

    $routes->add('app_logout', '/logout')
        ->methods(['GET'])
    ;

    $routes->add('app_forgot_password_request', '/reset-password')
        ->controller(['congregation_manager_app.controller.reset_password', 'request'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('app_check_email', '/reset-password/check-email')
        ->controller(['congregation_manager_app.controller.reset_password', 'checkEmail'])
        ->methods(['GET'])
    ;

    $routes->add('app_reset_password', '/reset-password/reset/{token}')
        ->controller(['congregation_manager_app.controller.reset_password', 'reset'])
        ->defaults([
            'token' => null,
        ])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('app_complete_account', '/complete/account/{token}')
        ->controller(['congregation_manager_app.controller.complete_account', 'complete'])
        ->defaults([
            'token' => null,
        ])
        ->methods(['GET', 'POST'])
    ;
};
