<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Context;

use CongregationManager\Component\Core\Domain\Context\ThemeContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class DateTimeThemeContext implements ThemeContextInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    #[\Override]
    public function useDarkTheme(): bool
    {
        $clientTimezone = $this->requestStack->getMainRequest()
            ?->server
            ->get('TZ')
        ;
        if (!is_string($clientTimezone) || $clientTimezone === '') {
            return false;
        }
        $dateTime = new \DateTimeImmutable('now', new \DateTimeZone($clientTimezone));
        $hour = (int) $dateTime->format('H');

        // Consider nighttime between 7 PM and 7 AM
        return $hour >= 19 || $hour < 7;
    }
}
