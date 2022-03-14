<?php

declare(strict_types=1);

namespace CongregationManager\Domain\User\Generator;

interface TokenGeneratorInterface
{
    public function generate(): string;
}
