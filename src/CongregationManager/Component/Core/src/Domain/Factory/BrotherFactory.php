<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\BrotherInterface as BaseBrotherInterface;
use CongregationManager\Component\Congregation\Domain\CongregationInterface as BaseCongregationInterface;
use CongregationManager\Component\Congregation\Domain\Factory\BrotherFactoryInterface;
use CongregationManager\Component\Core\Domain\Brother;
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
        BaseCongregationInterface $congregation,
        bool $male = true,
        ?string $middleName = null,
        ?DateTimeInterface $birthDate = null,
        ?DateTimeInterface $baptismDate = null,
    ): BaseBrotherInterface {
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
