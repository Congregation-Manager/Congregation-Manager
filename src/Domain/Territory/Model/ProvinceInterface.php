<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Model;

use CongregationManager\Domain\Common\Model\AggregateRootInterface;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use Doctrine\Common\Collections\Collection;

interface ProvinceInterface extends AggregateRootInterface
{
    public function getCongregation(): CongregationInterface;

    public function setCongregation(CongregationInterface $congregation): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    /**
     * @return Collection<array-key, MunicipalityInterface>
     */
    public function getMunicipalities(): Collection;

    public function addMunicipality(MunicipalityInterface $municipality): void;

    public function removeMunicipality(MunicipalityInterface $municipality): void;
}
