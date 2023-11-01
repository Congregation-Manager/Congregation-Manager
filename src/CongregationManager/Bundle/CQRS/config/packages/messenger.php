<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Contract\CQRS\CommandInterface;
use CongregationManager\Contract\CQRS\QueryInterface;
use Symfony\Config\Framework\Messenger\RoutingConfig;
use Symfony\Config\Framework\Messenger\TransportConfig;
use Symfony\Config\FrameworkConfig;
use Webmozart\Assert\Assert;

/** @psalm-suppress UndefinedClass */
return static function (FrameworkConfig $framework): void {
    // The bus that is going to be injected when injecting MessageBusInterface
    $framework->messenger()->defaultBus('command.bus');

    $commandBus = $framework->messenger()->bus('command.bus');
    $commandBus->middleware()->id('validation');
    $commandBus->middleware()->id('doctrine_transaction');

    $queryBus = $framework->messenger()->bus('query.bus');
    $queryBus->middleware()->id('validation');

    $asyncTransport = $framework->messenger()->transport('async');
    Assert::isInstanceOf($asyncTransport, TransportConfig::class);
    $asyncTransport->dsn(env('MESSENGER_TRANSPORT_DSN'));

    $syncTransport = $framework->messenger()->transport('sync');
    Assert::isInstanceOf($syncTransport, TransportConfig::class);
    $syncTransport->dsn('sync://');

    $commandRouting = $framework->messenger()->routing(CommandInterface::class);
    Assert::isInstanceOf($commandRouting, RoutingConfig::class);
    $commandRouting->senders(['async']);

    $queryRouting = $framework->messenger()->routing(QueryInterface::class);
    Assert::isInstanceOf($queryRouting, RoutingConfig::class);
    $queryRouting->senders(['sync']);
};
