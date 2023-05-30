<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Controller;

use CongregationManager\Bundle\User\Action\CreateAppUser;
use CongregationManager\Bundle\User\Entity\CompleteAccount;
use CongregationManager\Bundle\User\Form\CompleteAccountFormType;
use CongregationManager\Component\User\Domain\Repository\AppUserInvitationRepositoryInterface;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AppCompleteAccountController extends AbstractController
{
    private SessionInterface $session;

    public function __construct(
        private RequestStack $requestStack,
        private AppUserInvitationRepositoryInterface $appUserInvitationRepository,
        private CreateAppUser $createAppUser,
        private EntityManagerInterface $entityManager
    ) {
        $this->session = $requestStack->getSession();
    }

    public function complete(Request $request, string $token = null): Response
    {
        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('app_complete_account');
        }
        $token = $this->getTokenFromSession();
        if ($token === null) {
            throw $this->createNotFoundException('No invitation token found in the URL or in the session.');
        }

        $appUserInvitation = $this->appUserInvitationRepository->findByToken($token);
        if ($appUserInvitation === null) {
            throw $this->createNotFoundException('No invitation token found in the URL or in the session.');
        }

        if ($appUserInvitation->getCreatedAt()->add(new DateInterval('PT24H')) <= new DateTime()) {
            throw $this->createNotFoundException('No invitation token found in the URL or in the session.');
        }
        $completeAccount = new CompleteAccount(
            $appUserInvitation->getBrother(),
            $appUserInvitation->getEmail(),
            ''
        );
        $completeAccountForm = $this->createForm(CompleteAccountFormType::class, $completeAccount);
        $completeAccountForm->handleRequest($request);
        if ($completeAccountForm->isSubmitted() && $completeAccountForm->isValid()) {
            // An app user invitation token should be used only once, remove it.
            $this->appUserInvitationRepository->remove($appUserInvitation);

            $currentRequest = $this->requestStack->getCurrentRequest();
            $this->createAppUser->create(
                $completeAccount->getBrother(),
                $completeAccount->getEmail(),
                $completeAccount->getPlainPassword(),
                $currentRequest?->getLocale()
            );

            $this->entityManager->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('app_login');
        }

        return $this->renderForm('@CongregationManagerApp/complete_account/complete.html.twig', [
            'completeAccount' => $completeAccountForm,
        ]);
    }

    private function storeTokenInSession(string $token): void
    {
        $this->session->set('CompleteAccountToken', $token);
    }

    private function getTokenFromSession(): ?string
    {
        /** @var string|int|null $token */
        $token = $this->session->get('CompleteAccountToken');
        if ($token === null) {
            return null;
        }

        return (string) $token;
    }

    private function cleanSessionAfterReset(): void
    {
        $this->session->remove('CompleteAccountToken');
    }
}
