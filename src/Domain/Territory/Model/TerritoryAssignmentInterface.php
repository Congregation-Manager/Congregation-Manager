<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use CongregationManager\Domain\Common\Model\AggregateRootInterface;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use DateTimeInterface;

interface TerritoryAssignmentInterface extends AggregateRootInterface
{
    public function getTerritory(): TerritoryInterface;

    public function setTerritory(TerritoryInterface $territory): void;

    public function getAssignmentDate(): DateTimeInterface;

    public function setAssignmentDate(DateTimeInterface $assignmentDate): void;

    public function getBrother(): ?BrotherInterface;

    public function setBrother(?BrotherInterface $brother): void;

    public function getRevocationDate(): ?DateTimeInterface;

    public function setRevocationDate(?DateTimeInterface $revocationDate): void;

    public function getExpirationDate(): ?DateTimeInterface;
}
