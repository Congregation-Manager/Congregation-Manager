<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Page\Admin\LoginPageInterface;
use Webmozart\Assert\Assert;

final class LocaleContext implements Context
{
    public function __construct(
        private LoginPageInterface $loginPage
    ) {
    }

    /**
     * @When I visit the administration login page
     */
    public function iVisitTheAdministrationLoginPage(): void
    {
        $this->loginPage->open();
    }

    /**
     * @Then I should use the :locale locale
     */
    public function iShouldUsingTheLocale(string $locale): void
    {
        Assert::eq($this->loginPage->getActiveLocale(), $locale);
    }

    /**
     * @Then I should be able to use the :locale locale
     */
    public function iShouldBeAbleToUseTheLocale(string $locale): void
    {
        Assert::oneOf($locale, $this->loginPage->getAvailableLocales());
    }

    /**
     * @Given I switch to the :locale locale
     */
    public function iSwitchToTheLocale(string $locale): void
    {
        $this->loginPage->switchLocale($locale);
    }
}
