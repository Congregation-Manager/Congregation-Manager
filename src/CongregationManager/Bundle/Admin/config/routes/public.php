<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('admin_index', '/')
        ->controller([RedirectController::class])
        ->defaults([
            'route' => 'admin_login',
            'permanent' => true,
            'keepQueryParams' => true,
            'keepRequestMethod' => false,
        ])
    ;

    $routes->add('admin_switch_locale', '/switch-locale/{locale}')
        ->controller(['congregation_manager_admin.controller.locale', 'switchLocale'])
        ->defaults([
            'locale' => '%supported_locales%',
        ])
        ->methods(['GET'])
    ;

    $routes->add('admin_login', '/login')
        ->controller(['congregation_manager_admin.controller.login', 'index'])
        ->methods(['GET'])
    ;

    $routes->add('admin_login_check', '/login-check')
        ->methods(['POST'])
    ;

    $routes->add('admin_logout', '/logout')
        ->methods(['GET'])
    ;

    $routes->add('admin_forgot_password_request', '/reset-password')
        ->controller(['congregation_manager_admin.controller.reset_password', 'request'])
        ->methods(['GET', 'POST'])
    ;

    $routes->add('admin_check_email', '/reset-password/check-email')
        ->controller(['congregation_manager_admin.controller.reset_password', 'checkEmail'])
        ->methods(['GET'])
    ;

    $routes->add('admin_reset_password', '/reset-password/reset/{token}')
        ->controller(['congregation_manager_admin.controller.reset_password', 'reset'])
        ->defaults([
            'token' => null,
        ])
        ->methods(['GET', 'POST'])
    ;
};
