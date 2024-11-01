<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\TwigRuntime;

use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Contracts\Translation\TranslatableInterface;
use Twig\Extension\RuntimeExtensionInterface;

final readonly class TranslationRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private TranslationExtension $translationExtension,
    ) {
    }

    /**
     * @param array<string, string>|string $arguments Can be the locale as a string when $message is a TranslatableInterface
     */
    public function trans(
        string|\Stringable|TranslatableInterface|null $message,
        array|string $arguments = [],
        ?string $locale = null,
        ?int $count = null
    ): string {
        return $this->translationExtension->trans($message, $arguments, 'app', $locale, $count);
    }
}
