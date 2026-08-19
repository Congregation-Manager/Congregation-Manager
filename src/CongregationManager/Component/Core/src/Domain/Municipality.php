<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Municipality as BaseMunicipality;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Contract\Resource\AggregateRootId;

class Municipality extends BaseMunicipality implements MunicipalityInterface
{
    public function __construct(
        AggregateRootId $id,
        protected CongregationInterface $congregation,
        ProvinceInterface $province,
        string $name,
        ?string $description = null,
    ) {
        parent::__construct($id, $province, $name, $description);
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
