<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Ui\App;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Page\App\Territory\ShowPageInterface;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

final readonly class TerritoryContext implements Context
{
    public function __construct(
        private ShowPageInterface $showPage,
    ) {
    }

    /**
     * @Then I should be redirected to territory :territory page
     */
    public function iShouldBeRedirectedToTerritoryPage(TerritoryInterface $territory): void
    {
        $this->showPage->verify([
            'id' => $territory->getId(),
        ]);
    }

    /**
     * @Then I should see :count territory assignment
     */
    public function iShouldSeeTerritoryAssignment(int $count): void
    {
        Assert::eq($this->showPage->getTerritoryAssignmentsCount(), $count);
    }

    /**
     * @Given the last one territory assignment should be assigned to brother :brother
     */
    public function theLastOneTerritoryAssignmentShouldBeAssignedToBrother(BrotherInterface $brother): void
    {
        Assert::eq($this->showPage->getLastTerritoryAssignmentBrother(), (string) $brother);
    }

    /**
     * @Then the first territory assignment should be assigned to brother :brother
     */
    public function theFirstTerritoryAssignmentShouldBeAssignedToBrother(BrotherInterface $brother): void
    {
        Assert::eq($this->showPage->getFirstTerritoryAssignmentBrother(), (string) $brother);
    }

    /**
     * @Given the last one territory assignment should be assigned starting from :startingDate
     */
    public function theLastOneTerritoryAssignmentShouldBeAssignedStartingFrom(string $assignmentDate): void
    {
        Assert::eq(
            $this->showPage->getLastTerritoryAssignmentAssignmentDate(),
            new DateTimeImmutable($assignmentDate)
        );
    }

    /**
     * @Given the first territory assignment should be assigned starting from :assignmentDate
     */
    public function theFirstTerritoryAssignmentShouldBeAssignedStartingFrom(string $assignmentDate): void
    {
        Assert::eq(
            $this->showPage->getFirstTerritoryAssignmentAssignmentDate(),
            new DateTimeImmutable($assignmentDate)
        );
    }

    /**
     * @When I view the territory :territory page
     */
    public function iViewTheTerritoryPage(TerritoryInterface $territory): void
    {
        $this->showPage->open([
            'id' => $territory->getId(),
        ]);
    }
}
