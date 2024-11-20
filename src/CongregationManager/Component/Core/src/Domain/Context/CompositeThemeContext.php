<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Context;

use CongregationManager\Component\Core\Domain\Context\Exception\UnableToResolveThemeException;
use CongregationManager\Component\Core\Domain\Context\Exception\UnableToResolveThemeExceptionInterface;
use CongregationManager\Component\Core\Domain\Theme;

final readonly class CompositeThemeContext implements ThemeContextInterface
{
    /**
     * @param \IteratorAggregate<array-key, ThemeContextInterface>&\Countable $themeContexts
     */
    public function __construct(
        private \IteratorAggregate&\Countable $themeContexts,
    ) {
    }

    public function getTheme(): Theme
    {
        foreach ($this->themeContexts as $themeContext) {
            try {
                return $themeContext->getTheme();
            } catch (UnableToResolveThemeExceptionInterface) {
                continue;
            }
        }

        throw new UnableToResolveThemeException('Unable to resolve theme.');
    }
}
