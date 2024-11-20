<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Area as BaseArea;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;

class Area extends BaseArea implements AreaInterface
{
    public function __construct(
        protected CongregationInterface $congregation,
        MunicipalityInterface $municipality,
        string $name,
        ?string $description = null,
    ) {
        parent::__construct($municipality, $name, $description);
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
