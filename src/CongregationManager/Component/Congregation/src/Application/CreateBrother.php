<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Application;

use CongregationManager\Component\Congregation\Domain\Brother;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Congregation\Domain\Repository\BrotherRepositoryInterface;
use DateTimeInterface;

final readonly class CreateBrother
{
    public function __construct(
        private BrotherRepositoryInterface $brotherRepository
    ) {
    }

    public function create(
        string $firstName,
        string $lastName,
        CongregationInterface $congregation,
        bool $male = true,
        ?string $middleName = null,
        ?DateTimeInterface $birthDate = null,
        ?DateTimeInterface $baptismDate = null
    ): BrotherInterface {
        $brother = new Brother($firstName, $lastName, $congregation, $male, $middleName, $birthDate, $baptismDate);
        $this->brotherRepository->add($brother);

        return $brother;
    }
}
