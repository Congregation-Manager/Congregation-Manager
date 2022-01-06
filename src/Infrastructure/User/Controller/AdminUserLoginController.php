<?php


namespace App\Infrastructure\User\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class AdminUserLoginController extends AbstractController
{
    public function __construct(
        private AuthenticationUtils $authenticationUtils
    ) {
    }

    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin_dashboard');
        }

        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('admin/login/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
