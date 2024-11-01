<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\TerritoryManager\Renderer\WordS13Renderer;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_territory_manager.renderer.word_S13', WordS13Renderer::class)
        ->args([service('translator')])
    ;
};
