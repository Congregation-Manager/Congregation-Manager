<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\Generator;

use CongregationManager\Bundle\Resource\UuidV4;
use CongregationManager\CongregationManager\Contract\Resource\src\IdGeneratorInterface;
use CongregationManager\Contract\Resource\Id;

final readonly class UuidV4Generator implements IdGeneratorInterface
{
    public function generateNew(): Id
    {
        return new UuidV4();
    }
}
