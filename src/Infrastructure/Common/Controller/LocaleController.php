<?php


namespace App\Infrastructure\Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
final class LocaleController extends AbstractController
{
    public function __construct(
        private string $availableLocales,
        private SessionInterface $session
    ) {
    }

    public function switchLocale(Request $request, string $locale): Response
    {
        $this->session->set('_locale', $locale);
        return $this->redirectToRoute('app_homepage');
    }

    public function resolveForAdmin(Request $request): Response
    {
        $preferredLanguageLocaleCode = $this->getPreferredLanguageLocaleCode($request);
        if ($preferredLanguageLocaleCode === null) {
            $preferredLanguageLocaleCode = $request->getDefaultLocale();
        }

        return $this->redirectToRoute(
            'admin_dashboard',
            [
                '_locale' => $preferredLanguageLocaleCode
            ]
        );
    }

    private function getPreferredLanguageLocaleCode(Request $request): ?string
    {
        $availableLocalesCodes = explode('|', $this->availableLocales);
        $preferredLanguage = $request->getPreferredLanguage($availableLocalesCodes);
        if (!in_array($preferredLanguage, $availableLocalesCodes, true)) {
            return null;
        }

        return $preferredLanguage;
    }
}
