<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\Territory as BaseTerritory;

class Territory extends BaseTerritory implements TerritoryInterface
{
    public function __construct(
        protected CongregationInterface $congregation,
        AreaInterface $area,
        int $number,
        ?string $description = null,
    ) {
        parent::__construct($area, $number, $description);
    }

    #[\Override]
    public function getCongregation(): CongregationInterface
    {
        return $this->congregation;
    }

    #[\Override]
    public function setCongregation(CongregationInterface $congregation): void
    {
        $this->congregation = $congregation;
    }
}
