<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Component\Congregation\Domain\Persister\CongregationPersister;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_congregation.persister.congregation', CongregationPersister::class)
        ->args([
            service('congregation_manager_congregation.repository.congregation'),
            service('congregation_manager_resource.event_dispatcher.messenger'),
        ])
    ;
};
