<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Notificator;

use CongregationManager\Bundle\App\Notificator\Exception\MessageNotificatorMessageException;
use CongregationManager\Bundle\User\Entity\AppUserInterface;
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
    public function notifyUserResetPasswordToken(
        AppUserInterface $user,
        ResetPasswordToken $resetPasswordToken,
        string $localeCode,
    ): void {
        $email = (new TemplatedEmail())
            ->from(new Address(
                $this->fromEmail,
                $this->translator->trans('congregation_manager_app.email.from_name', [], 'app', $localeCode),
            ))
            ->to($user->getEmail())
            ->subject(
                $this->translator->trans(
                    'congregation_manager_app.email.reset_password.subject',
                    [],
                    'app',
                    $localeCode
                )
            )
            ->htmlTemplate('@CongregationManagerApp/email/reset_password.html.twig')
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
