<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Controller;

use CongregationManager\Infrastructure\User\Form\ChangeEmailFormType;
use CongregationManager\Infrastructure\User\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AdminProfileController extends AbstractController
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
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
        $changeEmailForm = $this->createForm(ChangeEmailFormType::class, $user);
        $changeEmailForm->handleRequest($request);

        if ($changeEmailForm->isSubmitted() && $changeEmailForm->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', $this->translator->trans('cm.ui.update_success'));

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->renderForm('admin/profile/update.html.twig', [
            'changeEmailForm' => $changeEmailForm,
        ]);
    }
}
