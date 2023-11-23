<?php

declare(strict_types=1);

namespace CongregationManager\Component\Resource\Factory;

use CongregationManager\Contract\Resource\ResourceInterface;

interface ResourceFactoryInterface
{
    public function createNew(): ResourceInterface;
}
