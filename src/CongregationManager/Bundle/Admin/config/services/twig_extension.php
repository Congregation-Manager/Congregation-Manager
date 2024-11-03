<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Admin\TwigExtension\TranslationExtension;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_admin.twig_extension.translation', TranslationExtension::class)
        ->tag('twig.extension')
    ;
};
