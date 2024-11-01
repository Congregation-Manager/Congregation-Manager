<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\EventSubscriber;

use CongregationManager\Component\User\Domain\UserInterface as DomainUserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

final readonly class UserLocaleSubscriber implements EventSubscriberInterface
{
    /**
     * @var string[]
     */
    private array $availableLocales;

    public function __construct(
        private RequestStack $requestStack,
        string $availableLocales
    ) {
        $this->availableLocales = explode('|', $availableLocales);
    }

    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event): void
    {
        /** @var SymfonyUserInterface|DomainUserInterface|null $user */
        $user = $event->getAuthenticationToken()
            ->getUser()
        ;

        if (!$user instanceof DomainUserInterface || $user->getLocaleCode() === null || !in_array(
            $user->getLocaleCode(),
            $this->availableLocales,
            true
        )) {
            return;
        }
        $this->requestStack->getSession()
            ->set('_locale', $user->getLocaleCode())
        ;
    }
}
