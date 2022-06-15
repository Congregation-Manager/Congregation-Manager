<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class LocaleSubscriber implements EventSubscriberInterface
{
    /**
     * @var string[]
     */
    private array $availableLocaleCodes = [];

    public function __construct(
        private string $defaultLocale,
        string $supportedLocales
    ) {
        $this->availableLocaleCodes = explode('|', $supportedLocales);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (! $request->hasPreviousSession()) {
            $request->setLocale($this->getPreferredLocaleCode($request) ?? $this->defaultLocale);

            return;
        }

        // if no explicit locale has been set on this request, use one from the session
        /** @var mixed|string $locale */
        $locale = $request->getSession()
            ->get('_locale', $this->defaultLocale)
        ;
        if (is_string($locale) && '' !== $locale) {
            $request->setLocale($locale);
        }
    }

    private function getPreferredLocaleCode(Request $request): ?string
    {
        $availableLocaleCodesWithSuperLanguage = array_merge(
            $this->availableLocaleCodes,
            $this->getSuperLanguageCodesFromLocaleCodes($this->availableLocaleCodes)
        );
        $preferredLocaleCode = $request->getPreferredLanguage($availableLocaleCodesWithSuperLanguage);
        if (null === $preferredLocaleCode) {
            return null;
        }
        if (in_array($preferredLocaleCode, $this->availableLocaleCodes, true)) {
            return $preferredLocaleCode;
        }
        $preferredLanguage = $this->getLanguageFromLocaleCode($preferredLocaleCode);

        foreach ($this->availableLocaleCodes as $localeCode) {
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
            if (! in_array($languageCode, $superLanguageCodes, true)) {
                $superLanguageCodes[] = $languageCode;
            }
        }

        return $superLanguageCodes;
    }

    private function getLanguageFromLocaleCode(string $localeCode): string
    {
        $position = strpos($localeCode, '_');
        if (false !== $position) {
            return substr($localeCode, 0, $position);
        }

        return $localeCode;
    }
}
