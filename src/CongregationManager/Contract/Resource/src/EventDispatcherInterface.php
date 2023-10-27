<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

interface EventDispatcherInterface
{
    public function dispatch(EventInterface $event): void;
}
