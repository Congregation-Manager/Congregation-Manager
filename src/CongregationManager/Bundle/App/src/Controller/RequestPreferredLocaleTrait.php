<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Controller;

use Symfony\Component\HttpFoundation\Request;

trait RequestPreferredLocaleTrait
{
    abstract private function getDefaultLocale(): string;

    /**
     * @return string[]
     */
    abstract private function getAvailableLocales(): array;

    private function getRightLocaleCodeForVisitor(Request $request): string
    {
        $localeCodeToUse = $this->getVisitorPreferredLocaleCode($request);

        return $localeCodeToUse ?? $this->getDefaultLocale();
    }

    private function getVisitorPreferredLocaleCode(Request $request): ?string
    {
        $availableLocaleCodes = $this->getAvailableLocales();
        $availableLocaleCodesWithSuperLanguage = array_merge(
            $availableLocaleCodes,
            $this->getSuperLanguageCodesFromLocaleCodes($availableLocaleCodes),
        );
        $preferredLocaleCode = $request->getPreferredLanguage($availableLocaleCodesWithSuperLanguage);
        if ($preferredLocaleCode === null) {
            return null;
        }
        if (in_array($preferredLocaleCode, $availableLocaleCodes, true)) {
            return $preferredLocaleCode;
        }
        $preferredLanguage = $this->getLanguageFromLocaleCode($preferredLocaleCode);

        foreach ($availableLocaleCodes as $localeCode) {
            $language = $this->getLanguageFromLocaleCode($localeCode);
            if ($language === $preferredLanguage) {
                return $localeCode;
            }
        }

        return null;
    }

    /**
     * @param string[] $localeCodes
     *
     * @return string[]
     */
    private function getSuperLanguageCodesFromLocaleCodes(array $localeCodes): array
    {
        $superLanguageCodes = [];
        foreach ($localeCodes as $localeCode) {
            $languageCode = $this->getLanguageFromLocaleCode($localeCode);
            if (!in_array($languageCode, $superLanguageCodes, true)) {
                $superLanguageCodes[] = $languageCode;
            }
        }

        return $superLanguageCodes;
    }

    private function getLanguageFromLocaleCode(string $localeCode): string
    {
        $position = strpos($localeCode, '_');
        if ($position !== false) {
            return substr($localeCode, 0, $position);
        }

        return $localeCode;
    }
}
