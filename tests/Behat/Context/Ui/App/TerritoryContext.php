<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Ui\App;

use Behat\Behat\Context\Context;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Tests\Behat\Page\App\Territory\ShowPage;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

final class TerritoryContext implements Context
{
    public function __construct(
        private ShowPage $showPage,
    ) {
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
