<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use CongregationManager\Contract\Resource\Exception\InvalidEventException;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;

abstract class AbstractResource implements ResourceInterface
{
    protected DateTimeInterface $createdAt;
    protected ?DateTimeInterface $updatedAt = null;

    /** @var Event[] */
    private array $events = [];

    /**
     * @throws Exception Emits Exception in case of an error while generating new DateTimeImmutable object.
     */
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
     * @throws InvalidEventException Emits InvalidEventException in case of an invalid event class name that not implements CongregationManager\Contract\Resource\Event class.
     * @throws Exception Emits Exception in case of an error while generating new DateTimeImmutable object.
     */
    final public function raise(string $event, array $payload = [], array $context = []): void
    {
        if (!is_a($event, Event::class, true)) {
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

    /**
     * @throws Exception Emits Exception in case of an error while generating new DateTimeImmutable object.
     */
    final protected function changeLastUpdatedToNow(): void
    {
        $this->updatedAt = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }
}
