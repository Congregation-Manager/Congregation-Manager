<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Services;

use Symfony\Component\Mailer\SentMessage;

final class EmailChecker implements EmailCheckerInterface
{
    #[\Override]
    public function hasMessageTo(string $message, string $recipient): bool
    {
        foreach (FakeMailerTransport::$sentMessages as $sentMessage) {
            if ($this->isMessageTo($sentMessage, $recipient)) {
                if (str_contains($sentMessage->getMessage()->toString(), $message)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function isMessageTo(SentMessage $message, string $recipient): bool
    {
        $sentMessageRecipients = $message->getEnvelope()
            ->getRecipients()
        ;
        foreach ($sentMessageRecipients as $messageRecipient) {
            if ($messageRecipient->getAddress() === $recipient) {
                return true;
            }
        }

        return false;
    }
}
