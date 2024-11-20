<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Context;

use CongregationManager\Component\Core\Domain\Theme;

final readonly class DefaultThemeContext implements ThemeContextInterface
{
    public const int PRIORITY = -100;

    #[\Override]
    public function getTheme(): Theme
    {
        return Theme::LIGHT;
    }
}
