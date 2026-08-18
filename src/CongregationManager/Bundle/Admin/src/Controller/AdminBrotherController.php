<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin\Controller;

use CongregationManager\Bundle\Admin\Notificator\MessageNotificatorInterface;
use CongregationManager\Bundle\User\Form\InviteUserFormType;
use CongregationManager\Component\Congregation\Domain\Repository\BrotherRepositoryInterface;
use CongregationManager\Component\Core\Application\CreateAppUserInvitation;
use CongregationManager\Component\Core\Domain\BrotherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AdminBrotherController extends AbstractController
{
    public function __construct(
        private readonly BrotherRepositoryInterface $brotherRepository,
        private readonly CreateAppUserInvitation $createAppUserInvitation,
        private readonly EntityManagerInterface $entityManager,
        private readonly MessageNotificatorInterface $messageNotificator,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function index(Request $request): Response
    {
        $brothers = $this->brotherRepository->findAll();

        return $this->render('@CongregationManagerAdmin/brother/index.html.twig', [
            'brothers' => $brothers,
        ]);
    }

    public function show(Request $request, int $id): Response
    {
        $brother = $this->brotherRepository->findOneById($id);
        if ($brother === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('@CongregationManagerAdmin/brother/show.html.twig', [
            'brother' => $brother,
        ]);
    }

    public function invite(Request $request, int $id): Response
    {
        $brother = $this->brotherRepository->findOneById($id);
        if (!$brother instanceof BrotherInterface) {
            throw new NotFoundHttpException();
        }
        $inviteUserForm = $this->createForm(InviteUserFormType::class);
        $inviteUserForm->handleRequest($request);
        if ($inviteUserForm->isSubmitted() && $inviteUserForm->isValid()) {
            /** @var array{email: string} $data */
            $data = $inviteUserForm->getData();
            $email = $data['email'];
            $appUserInvitation = $this->createAppUserInvitation->create($brother, $email);
            $brother->setInvitation($appUserInvitation);
            $this->entityManager->persist($appUserInvitation);
            $this->entityManager->flush();

            $this->messageNotificator->notifyAppInvitation($appUserInvitation, $request->getLocale());

            $this->addFlash(
                'success',
                $this->translator->trans('congregation_manager_admin.ui.invitation_sent_successfully', [], 'admin')
            );

            return $this->redirectToRoute('congregation_manager_admin_brother_show', [
                'id' => $brother->getId(),
            ]);
        }

        return $this->render('@CongregationManagerAdmin/brother/invite.html.twig', [
            'brother' => $brother,
            'inviteUserForm' => $inviteUserForm,
        ]);
    }
}
