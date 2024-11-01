<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Services\SharedStorageInterface;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Area;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\Territory;
use Doctrine\ORM\EntityManagerInterface;
use Webmozart\Assert\Assert;

final readonly class TerritoryContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private TerritoryRepositoryInterface $territoryRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @Given there is a territory :number
     */
    public function thereIsATerritory(int $number): void
    {
        /** @var CongregationInterface|mixed $congregation */
        $congregation = $this->sharedStorage->get('congregation');
        Assert::isInstanceOf($congregation, CongregationInterface::class);

        $territory = new Territory($congregation, $this->createAreaByCongregation($congregation), $number);

        $this->territoryRepository->add($territory);
        $this->entityManager->flush();

        $this->sharedStorage->set('territory', $territory);
    }

    private function createProvinceByCongregation(CongregationInterface $congregation): ProvinceInterface
    {
        $province = new Province($congregation, 'Carrollton');
        $this->entityManager->persist($province);

        return $province;
    }

    private function createMunicipalityByCongregation(CongregationInterface $congregation): MunicipalityInterface
    {
        $municipality = new Municipality(
            $congregation,
            $this->createProvinceByCongregation($congregation),
            'Carrollton'
        );
        $this->entityManager->persist($municipality);

        return $municipality;
    }

    private function createAreaByCongregation(CongregationInterface $congregation): AreaInterface
    {
        $area = new Area($congregation, $this->createMunicipalityByCongregation($congregation), 'Carrollton');
        $this->entityManager->persist($area);

        return $area;
    }
}
