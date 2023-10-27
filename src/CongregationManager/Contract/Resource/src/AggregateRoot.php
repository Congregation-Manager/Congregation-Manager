<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

abstract class AggregateRoot extends AbstractResource implements AggregateRootInterface
{
    /**
     * @var list<EventInterface>
     */
    private array $recordedEvents = [];

    /**
     * @return list<EventInterface>
     */
    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];

        return $events;
    }

    protected function recordThat(EventInterface $event): void
    {
        $this->recordedEvents[] = $event;
    }
}
