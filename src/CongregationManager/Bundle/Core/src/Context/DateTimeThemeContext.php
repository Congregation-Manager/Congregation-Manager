<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Context;

use CongregationManager\Component\Core\Domain\Context\ThemeContextInterface;

final readonly class DateTimeThemeContext implements ThemeContextInterface
{
    public function __construct(
    ) {
    }

    #[\Override]
    public function useDarkTheme(): bool
    {
        $dateTime = new \DateTimeImmutable('now');
        $hour = (int) $dateTime->format('H');

        // Consider nighttime between 7 PM and 7 AM
        return $hour >= 19 || $hour < 7;
    }
}
