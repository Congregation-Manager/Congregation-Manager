<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\TwigRuntime;

use CongregationManager\Component\Core\Domain\Context\ThemeContextInterface;
use Twig\Extension\RuntimeExtensionInterface;

final readonly class ThemeRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private ThemeContextInterface $themeContext,
    ) {
    }

    public function useDarkTheme(): bool
    {
        return $this->themeContext->useDarkTheme();
    }
}
