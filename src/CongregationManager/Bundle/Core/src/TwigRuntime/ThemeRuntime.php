<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\TwigRuntime;

use CongregationManager\Component\Core\Domain\Context\ThemeContextInterface;
use CongregationManager\Component\Core\Domain\Theme;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\RuntimeExtensionInterface;

final readonly class ThemeRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private ThemeContextInterface $themeContext,
        private TranslatorInterface $translator,
    ) {
    }

    public function getTheme(): string
    {
        return $this->themeContext->getTheme()
->value;
    }

    public function getName(Theme $theme): string
    {
        return $this->translator->trans('congregation_manager_core.theme.' . $theme->value);
    }

    public function getBootstrapIcon(Theme $theme): string
    {
        return match ($theme) {
            Theme::LIGHT => 'brightness-high-fill',
            Theme::DARK => 'moon-stars-fill',
        };
    }
}
