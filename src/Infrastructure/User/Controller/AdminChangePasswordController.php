<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Controller;

use CongregationManager\Infrastructure\User\Form\ChangePasswordFormType;
use CongregationManager\Infrastructure\User\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AdminChangePasswordController extends AbstractController
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function update(Request $request): Response
    {
        $user = $this->security->getUser();
        if (null === $user) {
            throw new AccessDeniedHttpException();
        }
        if (! $user instanceof UserInterface) {
            throw new \LogicException();
        }
        $changePasswordForm = $this->createForm(ChangePasswordFormType::class, $user, [
            'actual_password' => true,
        ]);
        $changePasswordForm->handleRequest($request);

        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $plainPassword = $changePasswordForm->get('plainPassword')
                ->getData()
            ;
            if (! is_string($plainPassword)) {
                throw new \InvalidArgumentException(sprintf(
                    'Password input not valid! Expected string, actual %s',
                    gettype($plainPassword)
                ));
            }
            // Encode(hash) the plain password, and set it.
            $encodedPassword = $this->userPasswordHasher->hashPassword($user, $plainPassword);

            $user->setPassword($encodedPassword);
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('cm.ui.update_success'));

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->renderForm('admin/password/update.html.twig', [
            'changePasswordForm' => $changePasswordForm,
        ]);
    }
}
