<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\CQRS\MessengerCommandBus;
use CongregationManager\Bundle\CQRS\MessengerQueryBus;
use CongregationManager\Contract\CQRS\CommandHandlerInterface;
use CongregationManager\Contract\CQRS\QueryHandlerInterface;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->instanceof(CommandHandlerInterface::class)
        ->tag('messenger.message_handler', [
            'bus' => 'command.bus',
        ])
    ;

    $services->instanceof(QueryHandlerInterface::class)
        ->tag('messenger.message_handler', [
            'bus' => 'query.bus',
        ])
    ;

    $services->set('congregation_manager_cqrs.messenger_command_bus', MessengerCommandBus::class)
        ->args([service('messenger.command_bus')])
    ;

    $services->set('congregation_manager_cqrs.messenger_command_bus', MessengerQueryBus::class)
        ->args([service('messenger.query_bus')])
    ;
};
