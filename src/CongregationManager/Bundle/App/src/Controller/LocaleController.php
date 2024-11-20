<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Controller;

use CongregationManager\Bundle\User\Entity\UIUserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/** @psalm-suppress PropertyNotSetInConstructor */
final class LocaleController extends AbstractController
{
    /**
     * @param string[] $availableLocales
     */
    public function __construct(
        private readonly array $availableLocales,
        private readonly RequestStack $requestStack,
        private readonly Security $security,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param array<string, string> $routeParameters
     */
    public function renderPublicAction(Request $request, string $routeName, array $routeParameters): Response
    {
        return $this->render('@CongregationManagerApp/components/locale/_public_switch_locale.html.twig', [
            'active' => $request->getLocale(),
            'locales' => $this->availableLocales,
            'route_name' => $routeName,
            'route_parameters' => $routeParameters,
        ]);
    }

    public function renderLoggedInAction(Request $request): Response
    {
        return $this->render('@CongregationManagerApp/components/locale/_logged_in_switch_locale.html.twig', [
            'active' => $request->getLocale(),
            'locales' => $this->availableLocales,
        ]);
    }

    public function switchLocale(Request $request, string $locale): Response
    {
        $user = $this->security->getUser();
        if ($user instanceof UIUserInterface) {
            $user->setLocaleCode($locale);
            $this->entityManager->flush();
        }
        $session = $this->requestStack->getSession();
        $session->set('_locale', $locale);

        return $this->redirectToRoute('app_dashboard');
    }
}
