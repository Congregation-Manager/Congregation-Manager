<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Admin\TwigRuntime\TranslationRuntime;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_admin.twig_runtime.translation', TranslationRuntime::class)
        ->args([service('twig.extension.trans')])
        ->tag('twig.runtime')
    ;
};
