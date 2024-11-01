<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @psalm-suppress PropertyNotSetInConstructor */
final class EntrypointController extends AbstractController
{
    /**
     * @param string[] $availableLocales
     */
    public function __construct(
        private readonly array $availableLocales,
        private readonly string $defaultLocale,
    ) {
    }

    public function index(Request $request): Response
    {
        $locale = $this->getRightLocaleCodeForVisitor($request);

        return $this->redirectToRoute('congregation_manager_app_homepage', [
            '_locale' => $locale,
        ]);
    }

    private function getRightLocaleCodeForVisitor(Request $request): string
    {
        $localeCodeToUse = $this->getVisitorPreferredLocaleCode($request);

        return $localeCodeToUse ?? $this->defaultLocale;
    }

    private function getVisitorPreferredLocaleCode(Request $request): ?string
    {
        $availableLocaleCodes = $this->availableLocales;
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
