<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use Stringable;

interface AggregateRootInterface extends Stringable
{
    public function getId(): ?AggregateRootId;

    public function setId(?AggregateRootId $id): void;
}
