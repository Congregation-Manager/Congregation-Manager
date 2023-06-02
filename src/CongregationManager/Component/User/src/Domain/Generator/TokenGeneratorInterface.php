<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain\Generator;

interface TokenGeneratorInterface
{
    public function generate(): string;
}
