<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Context;

interface ThemeContextInterface
{
    public function useDarkTheme(): bool;
}
