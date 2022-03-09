<?php

namespace CongregationManager\Infrastructure\Common\Controller;

use CongregationManager\Infrastructure\Common\Form\ProfileUpdateFormType;
use CongregationManager\Infrastructure\Common\Model\ProfileUpdate;
use CongregationManager\Infrastructure\User\Model\AppUserInterface;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AppProfileController extends AbstractController
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
        if ($user === null) {
            throw new AccessDeniedHttpException();
        }
        if (!$user instanceof AppUserInterface) {
            throw new LogicException();
        }

        $profileUpdate = new ProfileUpdate($user->getBrother(), $user);
        $updateProfileForm = $this->createForm(ProfileUpdateFormType::class, $profileUpdate);
        $updateProfileForm->handleRequest($request);

        if ($updateProfileForm->isSubmitted() && $updateProfileForm->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', $this->translator->trans('cm.ui.update_success'));

            return $this->redirectToRoute('app_dashboard');
        }
        return $this->renderForm('app/profile/update.html.twig', [
            'updateProfileForm' => $updateProfileForm,
        ]);
    }
}
