<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Municipality as BaseMunicipality;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;

class Municipality extends BaseMunicipality implements MunicipalityInterface
{
    public function __construct(
        protected CongregationInterface $congregation,
        ProvinceInterface $province,
        string $name,
        ?string $description = null,
    ) {
        parent::__construct($province, $name, $description);
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
