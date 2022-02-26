<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Ui\App;

use Behat\Behat\Context\Context;
use CongregationManager\Tests\Behat\Page\App\HomePageInterface;
use Webmozart\Assert\Assert;

final class LocaleContext implements Context
{
    public function __construct(
        private HomePageInterface $homePage
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
        Assert::eq($this->homePage->getActiveLocale(), $locale);
    }

    /**
     * @Then I should be able to use the :locale locale
     */
    public function iShouldBeAbleToUseTheLocale(string $locale): void
    {
        Assert::oneOf($locale, $this->homePage->getAvailableLocales());
    }

    /**
     * @Given I switch to the :locale locale
     */
    public function iSwitchToTheLocale(string $locale): void
    {
        $this->homePage->switchLocale($locale);
    }
}
