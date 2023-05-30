<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Ui\App;

use Behat\Behat\Context\Context;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use CongregationManager\Tests\Behat\Page\App\TerritoryAssignment\CreatePage;
use CongregationManager\Tests\Behat\Page\App\TerritoryAssignment\UpdatePage;
use CongregationManager\Tests\Behat\Services\SharedStorageInterface;
use DateTimeImmutable;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

final class TerritoryAssignmentContext implements Context
{
    public function __construct(
        private CreatePage $assignPage,
        private UpdatePage $updatePage,
        private SharedStorageInterface $sharedStorage,
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
        Assert::true(
            $this->assignPage->hasErrorMessage($this->translator->trans(
                'This value should be greater than or equal to {{ compared_value }}.',
                [
                    '{{ compared_value }}' => (new DateTimeImmutable($assignmentDate))->format('M d, Y, h:i A'),
                ],
                'validators'
            ))
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
}
