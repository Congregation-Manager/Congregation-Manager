<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\RawMessage;
use Twig\Environment;

final class FakeMailerTransport implements TransportInterface
{
    /**
     * @var SentMessage[]
     */
    public static array $sentMessages = [];

    public function __construct(
        private readonly Environment $twig
    ) {
    }

    #[\Override]
    public function __toString(): string
    {
        return 'behat';
    }

    #[\Override]
    public function send(RawMessage $message, Envelope $envelope = null): ?SentMessage
    {
        if ($message instanceof TemplatedEmail) {
            $sentMessage = new SentMessage(
                new RawMessage($this->twig->render((string) $message->getHtmlTemplate(), $message->getContext())),
                new Envelope($message->getSender() ?? new Address('no-reply@cm.org'), $message->getTo())
            );
        } else {
            $sentMessage = new SentMessage(
                $message,
                $envelope ??
                new Envelope(new Address('no-reply@cm.org'), [new Address('no-reply@cm.org')])
            );
        }
        self::$sentMessages[] = $sentMessage;

        return $sentMessage;
    }
}
