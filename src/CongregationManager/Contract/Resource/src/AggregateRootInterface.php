<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

interface AggregateRootInterface extends \Stringable
{
    public function getId(): ?int;

    public function setId(?int $id): void;
}
