<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Ui\App;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Page\App\TerritoryAssignment\CreatePage;
use CongregationManager\Behat\Page\App\TerritoryAssignment\UpdatePage;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeImmutable;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

final readonly class TerritoryAssignmentContext implements Context
{
    public function __construct(
        private CreatePage $assignPage,
        private UpdatePage $updatePage,
        private TranslatorInterface $translator,
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
     * @Given I set revocation date as :revocationDate
     */
    public function iSetRevocationDateAs(string $revocationDate): void
    {
        $this->assignPage->specifyRevocationDate(new DateTimeImmutable($revocationDate));
    }

    /**
     * @Given I save territory assignment
     */
    public function iSaveTerritoryAssignment(): void
    {
        $this->assignPage->save();
    }

    /**
     * @Given I should be informed that the territory is conflicting another
     */
    public function iShouldBeInformedThatTheTerritoryIsConflictingAnother(): void
    {
        Assert::true(
            $this->assignPage->hasErrorMessage($this->translator->trans(
                'cm.valid_territory_assignments',
                [],
                'validators'
            ))
        );
    }

    /**
     * @Then I should be informed that revocation date should be greater or equal than :assignmentDate
     */
    public function iShouldBeInformedThatRevocationDateShouldBeGreaterOrEqualThanAssignmentDate(
        string $assignmentDate
    ): void {
        $errorMessage = $this->translator->trans(
            'This value should be greater than or equal to {{ compared_value }}.',
            [
                '{{ compared_value }}' => (new DateTimeImmutable($assignmentDate))->format('M d, Y, h:i A'),
            ],
            'validators'
        );
        Assert::true(
            $this->assignPage->hasErrorMessage($errorMessage),
            'Failed asserting that page contains the error message: ' . $errorMessage,
        );
    }

    /**
     * @Then I should be informed that assignment date is required
     */
    public function iShouldBeInformedThatAssignmentDateIsRequired(): void
    {
        Assert::true(
            $this->assignPage->hasErrorMessage($this->translator->trans(
                'This value should not be blank.',
                [],
                'validators'
            ))
        );
    }

    /**
     * @Given /^I am on the update page of (assignment of territory "[^"]+" of "[^"]+" starting on "[^"]+")$/
     */
    public function iAmOnTheUpdatePageOfAssignmentOfTerritoryOfStartingOn(
        TerritoryAssignmentInterface $territoryAssignment
    ): void {
        $this->updatePage->open([
            'id' => $territoryAssignment->getId(),
        ]);
    }
}
