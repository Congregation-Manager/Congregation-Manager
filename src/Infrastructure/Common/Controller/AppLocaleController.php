<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Controller;

use CongregationManager\Infrastructure\User\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AppLocaleController extends AbstractController
{
    public function __construct(
        private string $availableLocales,
        private RequestStack $requestStack,
        private Security $security,
        private EntityManagerInterface $entityManager
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
        $user = $this->security->getUser();
        if ($user instanceof UserInterface) {
            $user->setLocaleCode($locale);
            $this->entityManager->flush();
        }
        $session = $this->requestStack->getSession();
        $session->set('_locale', $locale);

        return $this->redirectToRoute('app_homepage');
    }
}
