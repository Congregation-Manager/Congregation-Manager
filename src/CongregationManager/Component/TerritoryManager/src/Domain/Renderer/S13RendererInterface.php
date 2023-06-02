<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Renderer;

use CongregationManager\Component\TerritoryManager\Domain\S13\S13;

interface S13RendererInterface
{
    public function render(S13 $s13): mixed;
}
