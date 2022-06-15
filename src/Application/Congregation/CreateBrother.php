<?php

declare(strict_types=1);

namespace CongregationManager\Application\Congregation;

use CongregationManager\Domain\Congregation\Model\Brother;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Congregation\Repository\BrotherRepositoryInterface;
use DateTimeInterface;

final class CreateBrother
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
