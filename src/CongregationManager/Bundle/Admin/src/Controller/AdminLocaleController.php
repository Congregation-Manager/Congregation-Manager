<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin\Controller;

use CongregationManager\Bundle\User\Entity\UIUserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AdminLocaleController extends AbstractController
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

    public function renderAction(Request $request): Response
    {
        return $this->render('@CongregationManagerAdmin/components/_switch_locale.html.twig', [
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
        $referer = $request->headers->get('referer');
        if ($referer !== null) {
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('congregation_manager_admin_dashboard');
    }
}
