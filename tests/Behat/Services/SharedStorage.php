<?php

namespace App\Tests\Behat\Services;

final class SharedStorage implements SharedStorageInterface
{
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
