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
use Symfony\Contracts\Translation\TranslatorInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AppCompleteAccountController extends AbstractController
{
    use RequestPreferredLocaleTrait;

    private readonly SessionInterface $session;

    /**
     * @param string[] $availableLocales
     */
    public function __construct(
        RequestStack $requestStack,
        private readonly AppUserInvitationRepositoryInterface $appUserInvitationRepository,
        private readonly CreateAppUser $createAppUser,
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator,
        private readonly string $defaultLocale,
        private readonly array $availableLocales,
    ) {
        $this->session = $requestStack->getSession();
    }

    public function complete(Request $request, string $token = null): Response
    {
        if ($token !== null) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('congregation_manager_app_complete_account_localized', [
                '_locale' => $this->getVisitorPreferredLocaleCode($request),
            ]);
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

            $this->createAppUser->create(
                $completeAccount->getBrother(),
                $completeAccount->getEmail(),
                $completeAccount->getPlainPassword(),
                $request->getLocale()
            );

            $this->entityManager->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            $this->addFlash(
                'success',
                $this->translator->trans('congregation_manager_app.ui.account_created_successfully', [], 'app')
            );

            return $this->redirectToRoute('congregation_manager_app_login', [
                '_locale' => $request->getLocale(),
            ]);
        }

        return $this->render('@CongregationManagerApp/complete_account/complete.html.twig', [
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

    private function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }

    /**
     * @return string[]
     */
    private function getAvailableLocales(): array
    {
        return $this->availableLocales;
    }
}
