<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Twig\LocaleExtension;
use CongregationManager\Bundle\Core\Twig\LocaleRuntime;
use CongregationManager\Bundle\Core\Twig\TestFormAttributeExtension;
use CongregationManager\Bundle\Core\Twig\TestHtmlAttributeExtension;
use CongregationManager\Bundle\Core\TwigExtension\ThemeExtension;
use CongregationManager\Bundle\Core\TwigRuntime\ThemeRuntime;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_core.twig_extension.locale', LocaleExtension::class)
        ->tag('twig.extension')
    ;

    $services->set('congregation_manager_core.twig_runtime.locale', LocaleRuntime::class)
        ->args([
            service('congregation_manager_core.converter.locale'),
            service('congregation_manager_core.context.locale'),
        ])
        ->tag('twig.runtime')
    ;

    $services->set('congregation_manager_core.twig_extension.test_form_attribute', TestFormAttributeExtension::class)
        ->args([param('kernel.environment')])
        ->tag('twig.extension')
    ;

    $services->set('congregation_manager_core.twig_extension.test_html_attribute', TestHtmlAttributeExtension::class)
        ->args([param('kernel.environment')])
        ->tag('twig.extension')
    ;

    $services->set('congregation_manager_core.twig_extension.theme', ThemeExtension::class)
        ->tag('twig.extension')
    ;

    $services->set('congregation_manager_core.twig_runtime.theme', ThemeRuntime::class)
        ->args([service('congregation_manager_core.context.theme'), service('translator')])
        ->tag('twig.runtime')
    ;
};
