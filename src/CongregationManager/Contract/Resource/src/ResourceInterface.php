<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use Stringable;

interface ResourceInterface extends Stringable
{
    public function getId(): Id;
}
