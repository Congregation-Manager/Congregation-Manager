<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Application\Command\CreateCongregation;

use CongregationManager\Component\Congregation\Domain\Factory\CongregationFactoryInterface;
use CongregationManager\Component\Congregation\Domain\Persister\CongregationPersisterInterface;
use CongregationManager\Contract\CQRS\CommandHandlerInterface;

final readonly class CreateCongregationHandler implements CommandHandlerInterface
{
    public function __construct(
        private CongregationPersisterInterface $congregationPersister,
        private CongregationFactoryInterface $congregationFactory,
    ) {
    }

    public function __invoke(CreateCongregationCommand $command): void
    {
        $congregation = $this->congregationFactory->createNew($command->name);
        $this->congregationPersister->save($congregation);
    }
}
