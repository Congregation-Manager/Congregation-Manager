<?php

declare(strict_types=1);

namespace CongregationManager\Contract\CQRS;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
