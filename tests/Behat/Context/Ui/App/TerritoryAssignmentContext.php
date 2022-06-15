<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Ui\App;

use Behat\Behat\Context\Context;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryAssignmentInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Tests\Behat\Page\App\TerritoryAssignment\CreatePage;
use CongregationManager\Tests\Behat\Page\App\TerritoryAssignment\UpdatePage;
use CongregationManager\Tests\Behat\Services\SharedStorageInterface;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

final class TerritoryAssignmentContext implements Context
{
    public function __construct(
        private CreatePage $assignPage,
        private UpdatePage $updatePage,
        private SharedStorageInterface $sharedStorage,
    ) {
    }

    /**
     * @Given I am on the assign territory :territory page
     */
    public function iAmOnTheAssignTerritoryPage(TerritoryInterface $territory): void
    {
        $this->assignPage->open([
            'territoryId' => $territory->getId(),
        ]);
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
     * @Given I am on the territory assignment update page
     */
    public function iAmOnTheTerritoryAssignmentUpdatePage(): void
    {
        /** @var TerritoryAssignmentInterface|null $territoryAssignment */
        $territoryAssignment = $this->sharedStorage->get('territory_assignment');
        Assert::isInstanceOf($territoryAssignment, TerritoryAssignmentInterface::class);

        $this->updatePage->open([
            'id' => $territoryAssignment->getId(),
        ]);
    }
}
