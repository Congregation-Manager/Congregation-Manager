<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Congregation\Repository\BrotherRepository;
use CongregationManager\Bundle\Congregation\Repository\CongregationRepository;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->alias('congregation_manager_congregation.repository.brother', BrotherRepository::class);
    $services->set(BrotherRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;

    $services->set('congregation_manager_congregation.repository.congregation', CongregationRepository::class)
        ->args([service('doctrine')])
        ->tag('doctrine.repository_service')
    ;
};
