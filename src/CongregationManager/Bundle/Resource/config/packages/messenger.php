<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Contract\Resource\EventInterface;
use Symfony\Config\Framework\Messenger\RoutingConfig;
use Symfony\Config\Framework\Messenger\TransportConfig;
use Symfony\Config\FrameworkConfig;
use Webmozart\Assert\Assert;

/** @psalm-suppress UndefinedClass */
return static function (FrameworkConfig $framework): void {
    $eventBus = $framework->messenger()
        ->bus('event.bus');
    $eventBus->middleware()
        ->id('validation');

    $transport = $framework->messenger()
        ->transport('sync');
    Assert::isInstanceOf($transport, TransportConfig::class);
    $transport->dsn('sync://');

    $routing = $framework->messenger()
        ->routing(EventInterface::class);
    Assert::isInstanceOf($routing, RoutingConfig::class);
    $routing->senders(['sync']);
};
