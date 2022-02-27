<?php

namespace CongregationManager\Domain\Common\Model;

abstract class AggregateRoot
{
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
