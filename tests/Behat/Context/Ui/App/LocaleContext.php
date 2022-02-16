<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\App;

use App\Infrastructure\Common\Locale\LocaleConverterInterface;
use App\Tests\Behat\Page\App\HomePageInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class LocaleContext implements Context
{
    public function __construct(
        private HomePageInterface $homePage,
        private LocaleConverterInterface $localeConverter
    ) {
    }

    /**
     * @When I visit the homepage
     */
    public function iVisitTheHomepage(): void
    {
        $this->homePage->open();
    }

    /**
     * @Then I should use the :locale locale
     */
    public function iShouldUsingTheLocale(string $locale): void
    {
        Assert::eq($this->homePage->getActiveLocale(), $this->localeConverter->convertNameToCode($locale));
    }
}
