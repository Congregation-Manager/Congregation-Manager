<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Component\Congregation\Domain\Congregation;
use CongregationManager\Component\Congregation\Domain\Factory\CongregationFactory;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_congregation.factory.congregation', CongregationFactory::class)
        ->args([Congregation::class, service('congregation_manager_resource.generator.uuidv4')])
    ;
};
