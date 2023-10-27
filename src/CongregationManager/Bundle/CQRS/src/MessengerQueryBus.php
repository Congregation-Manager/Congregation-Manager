<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\CQRS;

use CongregationManager\CongregationManager\Contract\CQRS\src\QueryBusInterface;
use CongregationManager\CongregationManager\Contract\CQRS\src\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(
        private MessageBusInterface $messageBus
    ) {
    }

    public function handle(QueryInterface $query): mixed
    {
        return $this->handleQuery($query);
    }
}
