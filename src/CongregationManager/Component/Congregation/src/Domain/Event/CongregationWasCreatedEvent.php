<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Event;


use CongregationManager\Contract\Resource\Event;
use Webmozart\Assert\Assert;

final readonly class CongregationWasCreatedEvent extends Event
{
    public function __construct(public string $name)
    {
    }

    public function __serialize(): array
    {
        return ['name' => $this->name];
    }

    public function __unserialize(array $data): void
    {
        $name = $data['name'];
        Assert::string($name);
        $this->name = $name;
    }
}
