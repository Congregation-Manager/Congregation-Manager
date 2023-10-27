<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Resource\EventDispatcher\MessengerEventDispatcher;
use CongregationManager\Bundle\Resource\Generator\UuidV4Generator;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_resource.generator.uuidv4', UuidV4Generator::class);

    $services->set('congregation_manager_resource.event_dispatcher.messenger', MessengerEventDispatcher::class)
        ->args([service('messenger.event_bus')])
    ;
};
