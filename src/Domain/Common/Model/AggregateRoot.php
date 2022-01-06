<?php


namespace App\Domain\Common\Model;

use App\Domain\Common\ValueObject\AggregateRootId;
use App\Domain\User\ValueObject\UserId;

abstract class AggregateRoot
{
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
