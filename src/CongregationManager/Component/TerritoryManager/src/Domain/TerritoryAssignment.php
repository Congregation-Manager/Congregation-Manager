<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Contract\Resource\AggregateRoot;
use DateInterval;
use DateTime;
use DateTimeInterface;
use InvalidArgumentException;

class TerritoryAssignment extends AggregateRoot implements TerritoryAssignmentInterface
{
    public function __construct(
        private TerritoryInterface $territory,
        private DateTimeInterface $assignmentDate,
        private ?BrotherInterface $brother = null,
        private ?DateTimeInterface $revocationDate = null
    ) {
        if ($this->revocationDate !== null && $this->revocationDate < $this->assignmentDate) {
            throw new InvalidArgumentException('Revocation date can not be less than assignment date.');
        }
    }

    #[\Override]
    public function __toString(): string
    {
        return sprintf(
            '%s[%s-%s]',
            self::class,
            (string) $this->getTerritory(),
            $this->getAssignmentDate()
                ->format('d-m-Y')
        );
    }

    #[\Override]
    public function getTerritory(): TerritoryInterface
    {
        return $this->territory;
    }

    #[\Override]
    public function setTerritory(TerritoryInterface $territory): void
    {
        $this->territory = $territory;
    }

    #[\Override]
    public function getAssignmentDate(): DateTimeInterface
    {
        return $this->assignmentDate;
    }

    #[\Override]
    public function setAssignmentDate(DateTimeInterface $assignmentDate): void
    {
        $this->assignmentDate = $assignmentDate;
    }

    #[\Override]
    public function getBrother(): ?BrotherInterface
    {
        return $this->brother;
    }

    #[\Override]
    public function setBrother(?BrotherInterface $brother): void
    {
        $this->brother = $brother;
    }

    #[\Override]
    public function getRevocationDate(): ?DateTimeInterface
    {
        return $this->revocationDate;
    }

    #[\Override]
    public function setRevocationDate(?DateTimeInterface $revocationDate): void
    {
        $this->revocationDate = $revocationDate;
    }

    #[\Override]
    public function getExpirationDate(): ?DateTimeInterface
    {
        $expirationDate = new DateTime($this->getAssignmentDate()->format('Y-m-d H:i:s'), $this->getAssignmentDate()
            ->getTimezone());

        return $expirationDate->add(new DateInterval('P4M'));
    }

    #[\Override]
    public function isGreaterThan(TerritoryAssignmentInterface $territoryAssignment): bool
    {
        if ($this->getRevocationDate() === null && $territoryAssignment->getRevocationDate() === null) {
            return $this->getAssignmentDate() > $territoryAssignment->getAssignmentDate();
        }
        if ($territoryAssignment->getRevocationDate() === null) {
            return false;
        }
        if ($this->getRevocationDate() === null) {
            return true;
        }
        if ($this->getAssignmentDate() > $territoryAssignment->getAssignmentDate() ||
            $this->getRevocationDate() > $territoryAssignment->getRevocationDate()
        ) {
            return true;
        }

        return false;
    }

    #[\Override]
    public function hasSameDatesTo(TerritoryAssignmentInterface $territoryAssignment): bool
    {
        if ($this === $territoryAssignment) {
            return true;
        }
        if ($this->getAssignmentDate()->diff($territoryAssignment->getAssignmentDate())->days !== 0) {
            return false;
        }
        $thisRevocationDate = $this->getRevocationDate();
        $otherRevocationDate = $territoryAssignment->getRevocationDate();
        if (!$thisRevocationDate instanceof DateTimeInterface) {
            return $otherRevocationDate === null;
        }
        if (!$otherRevocationDate instanceof DateTimeInterface) {
            return false;
        }
        $diff = $thisRevocationDate->diff($otherRevocationDate);

        return $diff->days === 0;
    }
}
