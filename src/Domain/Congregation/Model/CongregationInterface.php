<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Model;

use CongregationManager\Domain\Territory\Model\MunicipalityInterface;
use CongregationManager\Domain\Territory\Model\ProvinceInterface;
use Doctrine\Common\Collections\Collection;

interface CongregationInterface
{
    public function getId(): ?int;

    public function getName(): string;

    public function setName(string $name): void;

    /** @return Collection<array-key, BrotherInterface> */
    public function getBrothers(): Collection;

    public function addBrother(BrotherInterface $brother): void;

    public function removeBrother(BrotherInterface $brother): void;

    /** @return Collection<array-key, ProvinceInterface> */
    public function getProvinces(): Collection;

    public function addProvince(ProvinceInterface $province): void;

    public function removeProvince(ProvinceInterface $province): void;

    /** @return Collection<array-key, MunicipalityInterface> */
    public function getMunicipalities(): Collection;
}
