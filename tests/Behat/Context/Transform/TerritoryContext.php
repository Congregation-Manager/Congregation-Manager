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
        private readonly TerritoryRepositoryInterface $territoryRepository
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
