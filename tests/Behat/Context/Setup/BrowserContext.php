<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Infrastructure\Common\Converter\LocaleConverterInterface;
use Behat\Behat\Context\Context;
use Behat\Mink\Session;

final class BrowserContext implements Context
{
    public function __construct(
        private Session $session,
        private LocaleConverterInterface $localeConverter
    ) {
    }

    /**
     * @Given I use a browser set in the :locale preferred language
     */
    public function iUseABrowserSetInThePreferredLanguage(string $locale): void
    {
        $localeCode = $this->localeConverter->convertNameToCode($locale);
        $this->session->setRequestHeader('Accept-Language', str_replace('_', '-', $localeCode));
    }
}
