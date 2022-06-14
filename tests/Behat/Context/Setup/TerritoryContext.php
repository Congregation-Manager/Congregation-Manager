<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Territory\Model\Area;
use CongregationManager\Domain\Territory\Model\AreaInterface;
use CongregationManager\Domain\Territory\Model\Municipality;
use CongregationManager\Domain\Territory\Model\MunicipalityInterface;
use CongregationManager\Domain\Territory\Model\Province;
use CongregationManager\Domain\Territory\Model\ProvinceInterface;
use CongregationManager\Domain\Territory\Model\Territory;
use CongregationManager\Domain\Territory\Repository\TerritoryRepositoryInterface;
use CongregationManager\Tests\Behat\Services\SharedStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Webmozart\Assert\Assert;

final class TerritoryContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private TerritoryRepositoryInterface $territoryRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @Given there is a territory :name
     */
    public function thereIsATerritory(string $name): void
    {
        /** @var CongregationInterface|mixed $congregation */
        $congregation = $this->sharedStorage->get('congregation');
        Assert::isInstanceOf($congregation, CongregationInterface::class);

        $territory = new Territory($congregation, $this->createAreaByCongregation($congregation), $name);

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
        $area = new Area(
            $congregation,
            $this->createMunicipalityByCongregation($congregation),
            'Carrollton'
        );
        $this->entityManager->persist($area);

        return $area;
    }


}
