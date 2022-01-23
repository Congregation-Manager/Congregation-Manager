<?php

namespace App\Tests\Behat\Services;

interface SharedStorageInterface
{
    public function get(string $key): mixed;

    public function set(string $key, mixed $resource): void;
}
