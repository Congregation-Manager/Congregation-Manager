<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Area as BaseArea;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Contract\Resource\AggregateRootId;

class Area extends BaseArea implements AreaInterface
{
    public function __construct(
        AggregateRootId $id,
        protected CongregationInterface $congregation,
        MunicipalityInterface $municipality,
        string $name,
        ?string $description = null,
    ) {
        parent::__construct($id, $municipality, $name, $description);
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
