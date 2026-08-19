<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use DateTimeImmutable;

abstract class AggregateRoot implements AggregateRootInterface
{
    protected ?int $id = null;

    protected ?DateTimeImmutable $createdAt = null;

    protected ?DateTimeImmutable $updatedAt = null;

    #[\Override]
    abstract public function __toString(): string;

    #[\Override]
    public function getId(): ?int
    {
        return $this->id;
    }

    #[\Override]
    public function setId(?int $id): void
    {
        $this->id = $id;
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

    /**
     * Stamped by Doctrine rather than by the constructors, so that the resources keep
     * the constructors their own domain defines.
     */
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
