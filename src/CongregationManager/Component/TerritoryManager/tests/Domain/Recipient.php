<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Tests\Domain;

use CongregationManager\Component\TerritoryManager\Domain\RecipientInterface;

final readonly class Recipient implements RecipientInterface
{
    #[\Override]
    public function __toString(): string
    {
        return '';
    }
}
