<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use DateInterval;
use DateTime;
use DateTimeInterface;
use InvalidArgumentException;

final class TerritoryAssignment extends AggregateRoot implements TerritoryAssignmentInterface
{
    public function __construct(
        private TerritoryInterface $territory,
        private DateTimeInterface $assignmentDate,
        private ?BrotherInterface $brother = null,
        private ?DateTimeInterface $revocationDate = null
    ) {
    }

    public function getTerritory(): TerritoryInterface
    {
        return $this->territory;
    }

    public function setTerritory(TerritoryInterface $territory): void
    {
        $conflictinAssignemnts = $territory->getTerritoryAssignments()->filter(function (TerritoryAssignment $territoryAssignment) {
            if ($territoryAssignment->getRevocationDate() !== null) {
                if ($this->getRevocationDate() !== null) {
                    if (($this->getRevocationDate() > $territoryAssignment->getAssignmentDate()) || ($this->getAssignmentDate() >= $territoryAssignment->getAssignmentDate())) {
                        return true;
                    }
                } else {
                    return true;
                }
            } else {
                if ($this->getRevocationDate() !== null) {
                    if (($this->getRevocationDate() > $territoryAssignment->getAssignmentDate()) && ($this->getAssignmentDate() < $territoryAssignment->getRevocationDate())) {
                        return true;
                    }
                } else if ($this->getAssignmentDate() < $territoryAssignment->getRevocationDate()) {
                    return true;
                }
            }
            return false;
        });
        if ($conflictinAssignemnts->count() > 0) {
            throw new InvalidArgumentException('Another territory assignment for the territory exists');
        }
        $this->territory = $territory;
    }

    public function getAssignmentDate(): DateTimeInterface
    {
        return $this->assignmentDate;
    }

    public function setAssignmentDate(DateTimeInterface $assignmentDate): void
    {
        $this->assignmentDate = $assignmentDate;
    }

    public function getBrother(): ?BrotherInterface
    {
        return $this->brother;
    }

    public function setBrother(?BrotherInterface $brother): void
    {
        $this->brother = $brother;
    }

    public function getRevocationDate(): ?DateTimeInterface
    {
        return $this->revocationDate;
    }

    public function setRevocationDate(?DateTimeInterface $revocationDate): void
    {
        $this->revocationDate = $revocationDate;
    }

    public function getExpirationDate(): ?DateTimeInterface
    {
        $expirationDate = new DateTime($this->getAssignmentDate()->format('Y-m-d H:i:s'), $this->getAssignmentDate()->getTimezone());

        return $expirationDate->add(new DateInterval('P4M'));
    }
}
