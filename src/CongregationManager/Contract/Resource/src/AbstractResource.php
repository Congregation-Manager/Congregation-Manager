<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use CongregationManager\Contract\Resource\Exception\InvalidEventException;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

abstract class AbstractResource implements ResourceInterface
{
    protected DateTimeInterface $createdAt;

    protected ?DateTimeInterface $updatedAt = null;

    /**
     * @var Event[]
     */
    private array $events = [];

    public function __construct(
        protected Id $id,
    ) {
        $this->createdAt = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }

    abstract public function __toString(): string;

    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @param class-string $event
     * @param mixed[] $payload
     * @param mixed[] $context
     *
     * @psalm-suppress UnsafeInstantiation
     */
    final public function raise(string $event, array $payload = [], array $context = []): void
    {
        if (! is_a($event, Event::class, true)) {
            throw new InvalidEventException(
                sprintf('Provided event class name was not an instance of %s.', Event::class),
            );
        }

        $this->changeLastUpdatedToNow();
        $this->events[] = new $event($payload, $context, $this->__toString());
    }

    /**
     * @return Event[]
     */
    final public function releaseAndResetEvents(): array
    {
        $pendingEvents = $this->events;

        $this->events = [];

        return $pendingEvents;
    }

    final protected function changeLastUpdatedToNow(): void
    {
        $this->updatedAt = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }
}
