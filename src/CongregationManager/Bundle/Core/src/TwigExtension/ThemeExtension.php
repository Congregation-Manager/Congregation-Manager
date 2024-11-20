<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\TwigExtension;

use CongregationManager\Bundle\Core\TwigRuntime\ThemeRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class ThemeExtension extends AbstractExtension
{
    /**
     * @return TwigFunction[]
     */
    #[\Override]
    public function getFunctions(): array
    {
        return [new TwigFunction('get_theme', [ThemeRuntime::class, 'getTheme'])];
    }

    /**
     * @return TwigFilter[]
     */
    #[\Override]
    public function getFilters(): array
    {
        return [
            new TwigFilter('theme_name', [ThemeRuntime::class, 'getName']),
            new TwigFilter('theme_bootstrap_icon', [ThemeRuntime::class, 'getBootstrapIcon']),
        ];
    }
}
