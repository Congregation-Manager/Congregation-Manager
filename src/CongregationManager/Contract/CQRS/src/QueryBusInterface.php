<?php

declare(strict_types=1);

namespace CongregationManager\Contract\CQRS;

interface QueryBusInterface
{
    public function handle(QueryInterface $query): mixed;
}
