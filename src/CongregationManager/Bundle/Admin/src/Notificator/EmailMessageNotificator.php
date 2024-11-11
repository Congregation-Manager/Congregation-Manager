<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin\Notificator;

use CongregationManager\Bundle\Admin\Notificator\Exception\MessageNotificatorMessageException;
use CongregationManager\Bundle\User\Entity\AdminUserInterface;
use CongregationManager\Bundle\User\Entity\AppUserInvitation;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

final readonly class EmailMessageNotificator implements MessageNotificatorInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private TranslatorInterface $translator,
        private string $fromEmail,
    ) {
    }

    #[\Override]
    public function notifyAppUserInvitation(AppUserInvitation $appUserInvitation, string $localeCode): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address(
                $this->fromEmail,
                $this->translator->trans('congregation_manager_admin.email.from_name', [], 'admin', $localeCode)
            ))
            ->to($appUserInvitation->getEmail())
            ->subject(
                $this->translator->trans(
                    'congregation_manager_admin.email.app_user_invitation.subject',
                    [],
                    'admin',
                    $localeCode
                )
            )
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

    #[\Override]
    public function notifyAdminUserNotifyToken(
        AdminUserInterface $user,
        ResetPasswordToken $resetPasswordToken,
        string $localeCode,
    ): void {
        $email = (new TemplatedEmail())
            ->from(new Address(
                $this->fromEmail,
                $this->translator->trans('congregation_manager_admin.email.from_name', [], 'admin', $localeCode)
            ))
            ->to($user->getEmail())
            ->subject(
                $this->translator->trans(
                    'congregation_manager_admin.email.reset_password.subject',
                    [],
                    'admin',
                    $localeCode
                )
            )
            ->htmlTemplate('@CongregationManagerAdmin/email/reset_password.html.twig')
            ->context([
                'resetToken' => $resetPasswordToken,
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
