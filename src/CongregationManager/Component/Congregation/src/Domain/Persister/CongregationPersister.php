<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Persister;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Congregation\Domain\Repository\CongregationRepositoryInterface;
use CongregationManager\Contract\Resource\EventDispatcherInterface;

final readonly class CongregationPersister implements CongregationPersisterInterface
{
    public function __construct(
        private CongregationRepositoryInterface $congregationRepository,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function save(CongregationInterface $congregation): void
    {
        $this->congregationRepository->add($congregation);

        foreach ($congregation->releaseEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }
        $this->congregationRepository->flush();
    }
}
