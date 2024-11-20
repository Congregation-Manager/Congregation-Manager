<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Controller;

use CongregationManager\Bundle\App\Notificator\MessageNotificatorInterface;
use CongregationManager\Bundle\Core\Entity\AppUser;
use CongregationManager\Bundle\User\Entity\UIUserInterface;
use CongregationManager\Bundle\User\Exception\UserInstanceNotValid;
use CongregationManager\Bundle\User\Form\ChangePasswordFormType;
use CongregationManager\Bundle\User\Form\ResetPasswordRequestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
class ResetAppPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    public function __construct(
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly LoggerInterface $logger,
        private readonly MessageNotificatorInterface $messageNotificator,
    ) {
    }

    /**
     * Display & process form to request a password reset.
     */
    public function request(Request $request): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailFormData = $form->get('email')
                ->getData()
            ;
            if (!is_string($emailFormData)) {
                throw new \InvalidArgumentException(sprintf(
                    'Email input not valid! Expected string, actual %s',
                    gettype($emailFormData)
                ));
            }

            return $this->processSendingPasswordResetEmail($emailFormData, $request->getLocale());
        }

        return $this->render('@CongregationManagerApp/reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    /**
     * Confirmation page after a user has requested a password reset.
     */
    public function checkEmail(): Response
    {
        // Generate a fake token if the user does not exist or someone hit this page directly.
        // This prevents exposing whether or not a user was found with the given email address or not
        $resetToken = $this->getTokenObjectFromSession();
        if ($resetToken === null) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('@CongregationManagerApp/reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     */
    public function reset(Request $request, string $token = null): Response
    {
        if ($token !== null) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('congregation_manager_app_reset_password');
        }

        $token = $this->getTokenFromSession();
        if ($token === null) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        try {
            /** @var UIUserInterface $user */
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                'There was a problem validating your reset request - %s',
                $e->getReason()
            ));

            return $this->redirectToRoute('congregation_manager_app_forgot_password_request');
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user instanceof UIUserInterface) {
                throw new UserInstanceNotValid(sprintf(
                    'User instance not valid. Provided "%s", expected "%s"',
                    $user::class,
                    UIUserInterface::class
                ));
            }
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            $plainPassword = $form->get('plainPassword')
                ->getData()
            ;
            if (!is_string($plainPassword)) {
                throw new \InvalidArgumentException(sprintf(
                    'Password input not valid! Expected string, actual %s',
                    gettype($plainPassword)
                ));
            }
            // Encode(hash) the plain password, and set it.
            $encodedPassword = $this->userPasswordHasher->hashPassword($user, $plainPassword);

            $user->setPassword($encodedPassword);
            $this->entityManager->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('@CongregationManagerApp/reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

    private function processSendingPasswordResetEmail(
        string $emailFormData,
        string $currentLocaleCode
    ): RedirectResponse {
        $user = $this->entityManager->getRepository(AppUser::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Do not reveal whether a user account was found or not.
        if (!$user) {
            return $this->redirectToRoute('congregation_manager_app_check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            // If you want to tell the user why a reset email was not sent, uncomment
            // the lines below and change the redirect to 'congregation_manager_app_forgot_password_request'.
            // Caution: This may reveal if a user is registered or not.
            //
            // $this->addFlash('reset_password_error', sprintf(
            //     'There was a problem handling your password reset request - %s',
            //     $e->getReason()
            // ));
            $this->logger->error(
                sprintf(
                    'Unable to send reset password email for app user. Code "%s", message: %s',
                    $e->getCode(),
                    $e->getMessage()
                )
            );

            return $this->redirectToRoute('congregation_manager_app_check_email');
        }

        $this->messageNotificator->notifyUserResetPasswordToken(
            $user,
            $resetToken,
            $user->getLocaleCode() ?? $currentLocaleCode
        );

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('congregation_manager_app_check_email');
    }
}
