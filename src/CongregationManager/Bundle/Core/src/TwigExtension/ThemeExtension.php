<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\TwigExtension;

use CongregationManager\Bundle\Core\TwigRuntime\ThemeRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ThemeExtension extends AbstractExtension
{
    /**
     * @return TwigFunction[]
     */
    #[\Override]
    public function getFunctions(): array
    {
        return [new TwigFunction('use_dark_theme', [ThemeRuntime::class, 'useDarkTheme'])];
    }
}
