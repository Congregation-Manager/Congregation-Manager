<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

abstract class AbstractResource implements ResourceInterface
{
    public function __construct(
        protected Id $id,
    ) {
    }

    abstract public function __toString(): string;

    public function getId(): Id
    {
        return $this->id;
    }
}
