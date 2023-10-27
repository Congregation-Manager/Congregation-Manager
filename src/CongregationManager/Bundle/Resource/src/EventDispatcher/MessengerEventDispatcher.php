<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\EventDispatcher;

use CongregationManager\Contract\Resource\EventDispatcherInterface;
use CongregationManager\Contract\Resource\EventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerEventDispatcher implements EventDispatcherInterface
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    public function dispatch(EventInterface $event): void
    {
        $this->messageBus->dispatch($event);
    }
}
