<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\CQRS;

use CongregationManager\Contract\CQRS\CommandBusInterface;
use CongregationManager\Contract\CQRS\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerCommandBus implements CommandBusInterface
{
    public function __construct(
        private MessageBusInterface $messageBus
    ) {
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->messageBus->dispatch($command);
    }
}
