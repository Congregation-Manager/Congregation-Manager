<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Ui\App;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Tests\Behat\Page\App\Territory\AssignPage;
use CongregationManager\Tests\Behat\Page\App\Territory\ShowPage;
use DateTime;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

final class TerritoryContext implements Context
{
    public function __construct(
        private AssignPage $assignPage,
        private ShowPage $showPage,
    ) {
    }

    /**
     * @Given I am on the assign territory :territory page
     */
    public function iAmOnTheAssignTerritoryPage(TerritoryInterface $territory): void
    {
        $this->assignPage->open(['territoryId' => $territory->getId()]);
    }

    /**
     * @When I select brother :brother
     */
    public function iSelectBrother(BrotherInterface $brother): void
    {
        $this->assignPage->selectBrother($brother);
    }

    /**
     * @Then I should see that the territory :territory is selected
     */
    public function iShouldSeeThatTheTerritoryIsSelected(TerritoryInterface $territory): void
    {
        Assert::true($this->assignPage->isTerritorySelected($territory));
    }

    /**
     * @When I set assignment date as :assignmentDate
     */
    public function iSetAssignmentDateAs(string $assignmentDate): void
    {
        $this->assignPage->specifyAssignmentDate(new DateTimeImmutable($assignmentDate));
    }

    /**
     * @Given I save territory assignment
     */
    public function iSaveTerritoryAssignment(): void
    {
        $this->assignPage->save();
    }

    /**
     * @Then I should be redirected to territory :territory page
     */
    public function iShouldBeRedirectedToTerritoryPage(TerritoryInterface $territory): void
    {
        $this->showPage->verify(['id' => $territory->getId()]);
    }

    /**
     * @Then I should see :count territory assignment
     */
    public function iShouldSeeTerritoryAssignment(int $count): void
    {
        Assert::eq($this->showPage->getTerritoryAssignmentsCount(), $count);
    }

    /**
     * @Then the first territory assignment should be assigned to brother :brother
     */
    public function theFirstTerritoryAssignmentShouldBeAssignedToBrother(BrotherInterface $brother): void
    {
        Assert::eq($this->showPage->getFirstTerritoryAssignmentBrother(), (string) $brother);
    }

    /**
     * @Given the first territory assignment should be assigned starting from :assignmentDate
     */
    public function theFirstTerritoryAssignmentShouldBeAssignedStartingFrom(string $assignmentDate): void
    {
        Assert::eq($this->showPage->getFirstTerritoryAssignmentAssignmentDate(), new DateTimeImmutable($assignmentDate));
    }
}
