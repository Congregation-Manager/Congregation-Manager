<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;

class Congregation extends AggregateRoot implements CongregationInterface
{
    protected ?int $id = null;

    public function __construct(
        protected string $name
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
