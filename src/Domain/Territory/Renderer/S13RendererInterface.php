<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Renderer;

use CongregationManager\Domain\Territory\S13\S13;

interface S13RendererInterface
{
    public function render(S13 $s13): mixed;
}
