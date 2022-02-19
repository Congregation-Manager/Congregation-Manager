<?php

namespace App\Infrastructure\Common\Controller;

use App\Infrastructure\User\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AdminLocaleController extends AbstractController
{
    public function __construct(
        private string $availableLocales,
        private SessionInterface $session,
        private Security $security,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function renderAction(Request $request): Response
    {
        return $this->render('admin/components/_switch_locale.html.twig', [
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
        $this->session->set('_locale', $locale);
        return $this->redirectToRoute('admin_dashboard');
    }
}
