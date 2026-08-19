<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Province as BaseProvince;
use CongregationManager\Contract\Resource\AggregateRootId;

class Province extends BaseProvince implements ProvinceInterface
{
    public function __construct(
        AggregateRootId $id,
        protected CongregationInterface $congregation,
        string $name,
        ?string $description = null,
    ) {
        parent::__construct($id, $name, $description);
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
