<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Context;

use Symfony\Component\HttpFoundation\RequestStack;

final class LocaleContext implements LocaleContextInterface
{
    public function __construct(
        private RequestStack $requestStack
    ) {
    }

    public function getLocaleCode(): string
    {
        $request = $this->requestStack->getMainRequest();
        if ($request === null) {
            throw new LocaleNotFoundException('No master request available.');
        }

        /** @var string|null $localeCode */
        $localeCode = $request->getSession()
            ->get('_locale')
        ;
        if ($localeCode === null) {
            throw new LocaleNotFoundException('No locale attribute is set on the master request.');
        }

        return $localeCode;
    }
}
