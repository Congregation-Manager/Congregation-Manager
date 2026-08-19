<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use DateTimeImmutable;

abstract class AggregateRoot implements AggregateRootInterface
{
    protected ?DateTimeImmutable $createdAt = null;

    protected ?DateTimeImmutable $updatedAt = null;

    /**
     * A resource carries its identity from the moment it exists, so nothing can hand
     * around an aggregate that is not identifiable yet.
     */
    public function __construct(
        protected AggregateRootId $id
    ) {
    }

    #[\Override]
    abstract public function __toString(): string;

    #[\Override]
    public function getId(): AggregateRootId
    {
        return $this->id;
    }

    #[\Override]
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[\Override]
    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function initializeTimestamps(): void
    {
        $this->createdAt = new DateTimeImmutable('now');
        $this->updatedAt = $this->createdAt;
    }

    public function refreshUpdatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable('now');
    }
}
