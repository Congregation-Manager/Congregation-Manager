<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Services;

interface SharedStorageInterface
{
    public function get(string $key): mixed;

    public function set(string $key, mixed $resource): void;
}
