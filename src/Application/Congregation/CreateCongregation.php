<?php

declare(strict_types=1);

namespace CongregationManager\Application\Congregation;

use CongregationManager\Domain\Congregation\Model\Congregation;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Congregation\Repository\CongregationRepositoryInterface;

final class CreateCongregation
{
    public function __construct(
        private CongregationRepositoryInterface $congregationRepository
    ) {
    }

    public function create(string $name): CongregationInterface
    {
        $congregation = new Congregation($name);
        $this->congregationRepository->add($congregation);

        return $congregation;
    }
}
