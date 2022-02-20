<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Twig;

use App\Infrastructure\Common\Context\LocaleContextInterface;
use App\Infrastructure\Common\Context\LocaleNotFoundException;
use App\Infrastructure\Common\Converter\LocaleConverterInterface;
use InvalidArgumentException;
use Twig\Extension\RuntimeExtensionInterface;

final class LocaleRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private LocaleConverterInterface $localeConverter,
        private LocaleContextInterface $localeContext
    ) {
    }

    public function convertCodeToName(string $code, ?string $localeCode = null): ?string
    {
        try {
            return $this->localeConverter->convertCodeToName($code, $this->getLocaleCode($localeCode));
        } catch (InvalidArgumentException $e) {
            return $code;
        }
    }

    private function getLocaleCode(?string $localeCode): ?string
    {
        if (null !== $localeCode) {
            return $localeCode;
        }

        try {
            return $this->localeContext->getLocaleCode();
        } catch (LocaleNotFoundException $exception) {
            return null;
        }
    }
}
