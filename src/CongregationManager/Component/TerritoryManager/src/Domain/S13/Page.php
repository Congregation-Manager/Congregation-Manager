<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\S13;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;

final class Page
{
    public const int MAX_ROWS_ALLOWED = 20;

    /**
     * @var Collection<int, Row>
     */
    private Collection $rows;

    public function __construct(
        private int $serviceYear,
    ) {
        $this->rows = new ArrayCollection();
    }

    public function getServiceYear(): int
    {
        return $this->serviceYear;
    }

    public function setServiceYear(int $serviceYear): void
    {
        $this->serviceYear = $serviceYear;
    }

    /**
     * @return Collection<int, Row>
     */
    public function getRows(): Collection
    {
        return $this->rows;
    }

    /**
     * @param Collection<int, Row> $rows
     */
    public function setRows(Collection $rows): void
    {
        if ($rows->count() > self::MAX_ROWS_ALLOWED) {
            throw new InvalidArgumentException(sprintf(
                'Rows provided are more than rows allowed. Expected max: %s, got: %s.',
                self::MAX_ROWS_ALLOWED,
                $rows->count()
            ));
        }

        $this->rows = $rows;
    }

    public function addRow(Row $row): void
    {
        if ($this->rows->contains($row)) {
            return;
        }

        if ($this->rows->count() + 1 > self::MAX_ROWS_ALLOWED) {
            throw new InvalidArgumentException(sprintf(
                'The max number of rows per page is %s, the page is already full.',
                self::MAX_ROWS_ALLOWED
            ));
        }

        $this->rows->add($row);
    }

    public function removeRow(Row $row): void
    {
        if (!$this->rows->contains($row)) {
            return;
        }

        $this->rows->removeElement($row);
    }
}
