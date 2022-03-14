<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Congregation\Controller;

use CongregationManager\Domain\Congregation\Repository\BrotherRepositoryInterface;
use CongregationManager\Infrastructure\User\Action\CreateAppUserInvitation;
use CongregationManager\Infrastructure\User\Form\InviteUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/** @psalm-suppress PropertyNotSetInConstructor */
final class AdminBrotherController extends AbstractController
{
    public function __construct(
        private BrotherRepositoryInterface $brotherRepository,
        private CreateAppUserInvitation $createAppUserInvitation,
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer
    ) {
    }

    public function index(Request $request): Response
    {
        $brothers = $this->brotherRepository->findAll();
        return $this->render('admin/brother/index.html.twig', [
            'brothers' => $brothers,
        ]);
    }

    public function show(Request $request, int $id): Response
    {
        $brother = $this->brotherRepository->find($id);
        if ($brother === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('admin/brother/show.html.twig', [
            'brother' => $brother,
        ]);
    }

    public function invite(Request $request, int $id): Response
    {
        $brother = $this->brotherRepository->find($id);
        if ($brother === null) {
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

            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@congregation-manager.org', 'Congregation Manager'))
                ->to($email)
                ->subject('Your Congregation Manager invitation')
                ->htmlTemplate('email/admin/app_user_invitation.html.twig')
                ->context([
                    'invitationToken' => $appUserInvitation->getToken(),
                ])
            ;
            $this->mailer->send($email);

            return $this->redirectToRoute('admin_brother_show', ['id' => $brother->getId()]);
        }

        return $this->renderForm('admin/brother/invite.html.twig', [
            'brother' => $brother,
            'inviteUserForm' => $inviteUserForm
        ]);
    }
}
