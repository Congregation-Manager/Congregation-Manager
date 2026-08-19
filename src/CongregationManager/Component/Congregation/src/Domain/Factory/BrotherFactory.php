<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\Brother;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;
use DateTimeInterface;

final readonly class BrotherFactory implements BrotherFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createNew(
        string $firstName,
        string $lastName,
        CongregationInterface $congregation,
        bool $male = true,
        ?string $middleName = null,
        ?DateTimeInterface $birthDate = null,
        ?DateTimeInterface $baptismDate = null,
    ): BrotherInterface {
        return new Brother(
            $this->idGenerator->generateNew(),
            $firstName,
            $lastName,
            $congregation,
            $male,
            $middleName,
            $birthDate,
            $baptismDate
        );
    }
}
