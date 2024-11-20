<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Context;

use CongregationManager\Component\Core\Domain\Context\Exception\UnableToResolveThemeException;
use CongregationManager\Component\Core\Domain\Context\ThemeContextInterface;
use CongregationManager\Component\Core\Domain\Theme;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class RequestThemeContext implements ThemeContextInterface
{
    public const int PRIORITY = 0;

    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    #[\Override]
    public function getTheme(): Theme
    {
        $mainRequest = $this->requestStack->getMainRequest();
        if ($mainRequest === null) {
            throw new UnableToResolveThemeException('Unable to resolve request theme without a main request.');
        }
        $session = $mainRequest->getSession();
        $themeValue = $session->get('_theme');
        if ($themeValue === null || !is_string($themeValue)) {
            throw new UnableToResolveThemeException(
                'Unable to resolve request theme without a theme value in session.'
            );
        }
        $theme = Theme::tryFrom($themeValue);
        if ($theme === null) {
            throw new UnableToResolveThemeException('Invalid theme value in session.');
        }

        return $theme;
    }
}
