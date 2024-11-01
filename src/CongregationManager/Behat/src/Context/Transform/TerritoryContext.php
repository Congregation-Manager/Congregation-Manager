<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use Webmozart\Assert\Assert;

final readonly class TerritoryContext implements Context
{
    public function __construct(
        private TerritoryRepositoryInterface $territoryRepository
    ) {
    }

    /**
     * @Transform :territory
     */
    public function getTerritoryByNumber(int $number): TerritoryInterface
    {
        $territory = $this->territoryRepository->findOneByNumber($number);
        Assert::isInstanceOf($territory, TerritoryInterface::class);

        return $territory;
    }
}
