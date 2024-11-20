<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App\TerritoryAssignment;

use Behat\Mink\Element\NodeElement;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeImmutable;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Webmozart\Assert\Assert;

final class CreatePage extends SymfonyPage implements CreatePageInterface
{
    #[\Override]
    public function getRouteName(): string
    {
        return 'app_territory_assignment_create';
    }

    #[\Override]
    public function selectBrother(BrotherInterface $brother): void
    {
        $this->getElement('brother')
            ->selectOption((string) $brother)
        ;
    }

    #[\Override]
    public function isTerritorySelected(TerritoryInterface $territory): bool
    {
        $territorySelectOption = $this->getElement('territory')
            ->find('named', ['option', $territory->getNumber()]);
        Assert::isInstanceOf($territorySelectOption, NodeElement::class);

        return $territorySelectOption->hasAttribute('selected');
    }

    #[\Override]
    public function specifyAssignmentDate(DateTimeImmutable $assignmentDate): void
    {
        $this->getElement('assignment-date')
            ->setValue($assignmentDate->format('Y-m-d'))
        ;
    }

    #[\Override]
    public function specifyRevocationDate(DateTimeImmutable $revocationDate): void
    {
        $this->getElement('revocation-date')
            ->setValue($revocationDate->format('Y-m-d'))
        ;
    }

    #[\Override]
    public function save(): void
    {
        $this->getElement('save')
            ->click()
        ;
    }

    #[\Override]
    public function hasErrorMessage(string $message): bool
    {
        foreach ($this->getDocument()->findAll('css', $this->getDefinedElements()['errors']) as $errorMessage) {
            $cleanedHtmlErrorMessage = str_replace(' ', ' ', $errorMessage->getText());
            if ($message === $cleanedHtmlErrorMessage) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<string, string|string[]>
     */
    #[\Override]
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'errors' => '.invalid-feedback, .alert.alert-danger',
            'brother' => '[data-test-brother]',
            'assignment-date' => '[data-test-assignment-date]',
            'revocation-date' => '[data-test-revocation-date]',
            'territory' => '[data-test-territory]',
            'save' => '[data-test-save]',
        ]);
    }
}
