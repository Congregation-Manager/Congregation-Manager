<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('app_homepage', '/')
        ->controller(['cm.controller.homepage', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('app_switch_locale', '/switch-locale/{locale}')
        ->controller(['cm.controller.app_locale', 'switchLocale'])
        ->defaults(['locale' => '%supported_locales%'])
        ->methods(['GET'])
    ;

    $routes->add('app_login', '/login')
        ->controller(['cm.controller.app_user_login', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('app_login_check', '/login-check')
        ->methods(['POST'])
    ;

    $routes->add('app_logout', '/logout')
        ->methods(['GET'])
    ;

    $routes->add('app_forgot_password_request', '/reset-password')
        ->controller(['cm.controller.reset_app_password', 'request'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('app_check_email', '/reset-password/check-email')
        ->controller(['cm.controller.reset_app_password', 'checkEmail'])
        ->methods(['GET'])
    ;

    $routes->add('app_reset_password', '/reset-password/reset/{token}')
        ->controller(['cm.controller.reset_app_password', 'reset'])
        ->defaults(['token' => null])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('app_complete_account', '/complete/account/{token}')
        ->controller(['cm.controller.app_complete_account', 'complete'])
        ->defaults(['token' => null])
        ->methods(['GET', 'POST'])
    ;
};
