<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Context\CongregationContext;
use CongregationManager\Bundle\Core\Context\LocaleContext;
use CongregationManager\Bundle\Core\Context\RequestThemeContext;
use CongregationManager\Component\Core\Domain\Context\CompositeThemeContext;
use CongregationManager\Component\Core\Domain\Context\DateTimeThemeContext;
use CongregationManager\Component\Core\Domain\Context\DefaultThemeContext;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_core.context.congregation', CongregationContext::class)
        ->args([service('security.helper')])
    ;

    $services->set('congregation_manager_core.context.locale', LocaleContext::class)
        ->args([service('request_stack')])
    ;

    $services->set('congregation_manager_core.context.default_theme', DefaultThemeContext::class)
        ->tag('congregation_manager_core.context.theme', [
            'priority' => DefaultThemeContext::PRIORITY,
        ])
    ;

    $services->set('congregation_manager_core.context.date_time_theme', DateTimeThemeContext::class)
        ->tag('congregation_manager_core.context.theme', [
            'priority' => DateTimeThemeContext::PRIORITY,
        ])
    ;

    $services->set('congregation_manager_core.context.request_theme', RequestThemeContext::class)
        ->args([service('request_stack')])
        ->tag('congregation_manager_core.context.theme', [
            'priority' => RequestThemeContext::PRIORITY,
        ])
    ;

    $services->set('congregation_manager_core.context.composite_theme', CompositeThemeContext::class)
        ->args([tagged_iterator('congregation_manager_core.context.theme')])
    ;

    $services->alias(
        'congregation_manager_core.context.theme',
        'congregation_manager_core.context.composite_theme',
    );
};
