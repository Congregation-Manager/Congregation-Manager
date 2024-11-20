<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Context;

use CongregationManager\Component\Core\Domain\Theme;

interface ThemeContextInterface
{
    public function getTheme(): Theme;
}
