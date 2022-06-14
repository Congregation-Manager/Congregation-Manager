<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryRepositoryInterface;
use Webmozart\Assert\Assert;

final class TerritoryContext implements Context
{
    public function __construct(
        private TerritoryRepositoryInterface $territoryRepository
    ) {
    }

    /**
     * @Transform :territory
     */
    public function getTerritoryByName(string $name): TerritoryInterface
    {
        $territory = $this->territoryRepository->findOneByName($name);
        Assert::isInstanceOf($territory, TerritoryInterface::class);

        return $territory;
    }
}
