<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Application;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Congregation\Domain\Factory\CongregationFactoryInterface;
use CongregationManager\Component\Congregation\Domain\Repository\CongregationRepositoryInterface;

final readonly class CreateCongregation
{
    public function __construct(
        private CongregationFactoryInterface $congregationFactory,
        private CongregationRepositoryInterface $congregationRepository
    ) {
    }

    public function create(string $name): CongregationInterface
    {
        $congregation = $this->congregationFactory->createNew($name);
        $this->congregationRepository->add($congregation);

        return $congregation;
    }
}
