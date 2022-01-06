<?php


namespace App\Domain\Common\Model;

use App\Domain\Common\ValueObject\AggregateRootId;
use App\Domain\User\ValueObject\UserId;

abstract class AggregateRoot
{
    private AggregateRootId $id;

    public function getId(): AggregateRootId
    {
        return $this->id;
    }

    abstract public function setId(int $id): void;

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
