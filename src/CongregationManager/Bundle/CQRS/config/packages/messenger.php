<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Contract\CQRS\CommandInterface;
use CongregationManager\Contract\CQRS\QueryInterface;
use Symfony\Config\FrameworkConfig;

/** @psalm-suppress UndefinedClass */
return static function (FrameworkConfig $framework): void {
    // The bus that is going to be injected when injecting MessageBusInterface
    $framework->messenger()
        ->defaultBus('command.bus');

    $commandBus = $framework->messenger()
        ->bus('command.bus');
    $commandBus->middleware()
        ->id('validation');
    $commandBus->middleware()
        ->id('doctrine_transaction');

    $queryBus = $framework->messenger()
        ->bus('query.bus');
    $queryBus->middleware()
        ->id('validation');

    $framework->messenger()
        ->transport('async')
        ->dsn(env('MESSENGER_TRANSPORT_DSN'))
    ;

    $framework->messenger()
        ->transport('sync')
        ->dsn('sync://')
    ;

    $framework->messenger()
        ->routing(CommandInterface::class)->senders(['sync']);
    $framework->messenger()
        ->routing(QueryInterface::class)->senders(['sync']);
};
