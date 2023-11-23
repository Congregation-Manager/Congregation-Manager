<?php

declare(strict_types=1);

namespace CongregationManager\Component\Resource\Factory;

use CongregationManager\CongregationManager\Contract\Resource\src\IdGeneratorInterface;
use CongregationManager\Contract\Resource\ResourceInterface;
use Webmozart\Assert\Assert;

final readonly class ResourceFactory implements ResourceFactoryInterface
{
    public function __construct(
        private string $resourceClass,
        private IdGeneratorInterface $idGenerator,
    ) {
    }

    public function createNew(): ResourceInterface
    {
        $resource = new $this->resourceClass($this->idGenerator->generateNew(), ...func_get_args());
        Assert::isInstanceOf($resource, ResourceInterface::class);

        return $resource;
    }
}
