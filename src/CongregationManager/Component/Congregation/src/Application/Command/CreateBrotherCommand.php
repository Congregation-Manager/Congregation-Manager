<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Application\Command;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Contract\CQRS\CommandInterface;
use DateTimeInterface;

final class CreateBrotherCommand implements CommandInterface
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public CongregationInterface $congregation,
        public bool $male = true,
        public ?string $middleName = null,
        public ?DateTimeInterface $birthDate = null,
        public ?DateTimeInterface $baptismDate = null
    ) {
    }
}
