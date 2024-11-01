<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\App\TwigRuntime\TranslationRuntime;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_app.twig_runtime.translation', TranslationRuntime::class)
        ->args([
            service('twig.extension.trans'),
        ])
        ->tag('twig.runtime')
    ;
};
