<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Ui\App;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Page\App\DashboardPageInterface;
use CongregationManager\Behat\Page\App\EntrypointPageInterface;
use CongregationManager\Behat\Page\App\HomePageInterface;
use Webmozart\Assert\Assert;

final readonly class LocaleContext implements Context
{
    public function __construct(
        private EntrypointPageInterface $entrypointPage,
        private HomePageInterface $homePage,
        private DashboardPageInterface $dashboardPage,
    ) {
    }

    /**
     * @When I visit the homepage
     */
    public function iVisitTheHomepage(): void
    {
        $this->entrypointPage->tryToOpen();
        $this->homePage->verify();
    }

    /**
     * @Then I should use the :locale locale
     */
    public function iShouldUsingTheLocale(string $locale): void
    {
        Assert::eq($this->dashboardPage->getActiveLocale(), $locale);
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
