<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\EventSubscriber;

use CongregationManager\Bundle\App\Controller\RequestPreferredLocaleTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class LocaleSubscriber implements EventSubscriberInterface
{
    use RequestPreferredLocaleTrait;

    /**
     * @param string[] $availableLocaleCodes
     */
    public function __construct(
        private string $defaultLocale,
        private array $availableLocaleCodes,
    ) {
    }

    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            $request->setLocale($this->getRightLocaleCodeForVisitor($request));

            return;
        }

        // if no explicit locale has been set on this request, use one from the session
        /** @var mixed|string $locale */
        $locale = $request->getSession()
            ->get('_locale', $this->defaultLocale)
        ;
        if (is_string($locale) && $locale !== '') {
            $request->setLocale($locale);
        }
    }

    #[\Override]
    private function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }

    /**
     * @return string[]
     */
    #[\Override]
    private function getAvailableLocales(): array
    {
        return $this->availableLocaleCodes;
    }
}
