<?php

declare(strict_types=1);

namespace CongregationManager\CongregationManager\Contract\Resource\src;

use CongregationManager\Contract\Resource\Id;

interface IdGeneratorInterface
{
    public function generateNew(): Id;
}
