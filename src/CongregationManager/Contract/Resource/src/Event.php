<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

abstract readonly class Event implements EventInterface
{
    /**
     * @param mixed[] $payload
     * @param mixed[] $context
     * @param ?string $aggregate
     */
    public function __construct(
        private array $payload = [],
        private array $context = [],
        private ?string $aggregate = null,
    ) {
    }

    /**
     * @return mixed[]
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getAggregate(): ?string
    {
        return $this->aggregate;
    }

    /**
     * @return mixed[]
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
