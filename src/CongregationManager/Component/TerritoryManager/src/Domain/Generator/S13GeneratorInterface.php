<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Generator;

use CongregationManager\Component\TerritoryManager\Domain\S13\S13;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use Doctrine\Common\Collections\ReadableCollection;

interface S13GeneratorInterface
{
    /**
     * @param ReadableCollection<array-key, TerritoryInterface> $territories
     */
    public function generateForTerritoriesAndServiceYear(ReadableCollection $territories, int $serviceYear): S13;
}
