<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Common\Model;

interface AggregateRootInterface
{
    public function getId(): ?int;
}
