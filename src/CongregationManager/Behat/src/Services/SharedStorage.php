<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Services;

final class SharedStorage implements SharedStorageInterface
{
    /**
     * @var array<string, mixed>
     */
    private array $storage = [];

    public function get(string $key): mixed
    {
        return $this->storage[$key] ?? null;
    }

    public function set(string $key, mixed $resource): void
    {
        $this->storage[$key] = $resource;
    }
}
