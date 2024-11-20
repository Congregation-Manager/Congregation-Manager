<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Context;

use CongregationManager\Component\Core\Domain\Theme;

final readonly class DateTimeThemeContext implements ThemeContextInterface
{
    public const int PRIORITY = -50;

    #[\Override]
    public function getTheme(): Theme
    {
        $dateTime = new \DateTimeImmutable('now');
        $hour = (int) $dateTime->format('H');

        // Consider nighttime between 7 PM and 7 AM
        return $hour >= 19 || $hour < 7 ? Theme::DARK : Theme::LIGHT;
    }
}
