<?php


namespace App\Infrastructure\Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AppLocaleController extends AbstractController
{
    public function __construct(
        private string $availableLocales,
        private SessionInterface $session
    ) {
    }

    public function renderAction(Request $request): Response
    {
        return $this->render('app/components/_switch_locale.html.twig', [
            'active' => $request->getLocale(),
            'locales' => explode('|', $this->availableLocales),
        ]);
    }

    public function switchLocale(Request $request, string $locale): Response
    {
        $this->session->set('_locale', $locale);
        return $this->redirectToRoute('app_homepage');
    }
}
