<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Application\Command\CreateCongregation;

use CongregationManager\Contract\CQRS\Command;

final readonly class CreateCongregationCommand extends Command
{
    public function __construct(
        public string $name,
    ) {
    }
}
