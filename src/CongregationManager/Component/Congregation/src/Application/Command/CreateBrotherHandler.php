<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Application\Command;

use CongregationManager\Component\Congregation\Domain\Factory\BrotherFactoryInterface;
use CongregationManager\Contract\CQRS\CommandHandlerInterface;

final class CreateBrotherHandler implements CommandHandlerInterface
{
    public function __construct(
        private BrotherFactoryInterface $brotherFactory,
        private BrotherPersisterInterface $brotherPersister,
    ) {
    }

    public function __invoke(CreateBrotherCommand $command): void
    {
        $brother = $this->brotherFactory->createNew();
    }
}
