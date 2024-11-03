<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin\Notificator;

use CongregationManager\Bundle\Admin\Notificator\Exception\MessageNotificatorMessageException;
use CongregationManager\Bundle\User\Entity\AppUserInvitation;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class EmailMessageNotificator implements MessageNotificatorInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private TranslatorInterface $translator,
        private string $fromEmail,
    ) {
    }

    public function notifyAppUserInvitation(AppUserInvitation $appUserInvitation, string $localeCode): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address(
                $this->fromEmail,
                $this->translator->trans('cm.email.from_name', [], null, $localeCode)
            ))
            ->to($appUserInvitation->getEmail())
            ->subject($this->translator->trans('cm.email.app_user_invitation.subject', [], null, $localeCode))
            ->htmlTemplate('@CongregationManagerAdmin/email/app_user_invitation.html.twig')
            ->context([
                'invitationToken' => $appUserInvitation->getToken(),
                'localeCode' => $localeCode,
            ])
        ;

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new MessageNotificatorMessageException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
