<?php

declare(strict_types=1);

namespace CongregationManager\Component\Resource\Persister;

use CongregationManager\Component\Resource\Repository\ResourceRepositoryInterface;
use CongregationManager\Contract\Resource\EventDispatcherInterface;
use CongregationManager\Contract\Resource\ResourceInterface;

final readonly class ResourcePersister implements ResourcePersisterInterface
{
    public function __construct(
        private ResourceRepositoryInterface $resourceRepository,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function save(ResourceInterface $resource): void
    {
        $this->resourceRepository->add($resource);

        foreach ($resource->releaseEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }
        $this->resourceRepository->flush();
    }
}
