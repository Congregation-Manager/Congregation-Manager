<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\App\TerritoryAssignment;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use DateTimeImmutable;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class CreatePage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_territory_assignment_create';
    }

    public function selectBrother(BrotherInterface $brother): void
    {
        $this->getElement('brother')
            ->selectOption((string) $brother)
        ;
    }

    public function isTerritorySelected(TerritoryInterface $territory): bool
    {
        return $this->getElement('territory')
            ->find('named', ['option', $territory->getName()])->hasAttribute('selected');
    }

    public function specifyAssignmentDate(DateTimeImmutable $assignmentDate): void
    {
        $this->getElement('assignment-date')
            ->setValue($assignmentDate->format('Y-m-d'))
        ;
    }

    public function specifyRevocationDate(DateTimeImmutable $revocationDate)
    {
        $this->getElement('revocation-date')
            ->setValue($revocationDate->format('Y-m-d'))
        ;
    }

    public function save(): void
    {
        $this->getElement('save')
            ->click()
        ;
    }

    public function hasErrorMessage(string $message): bool
    {
        foreach ($this->getDocument()->findAll('css', $this->getDefinedElements()['errors']) as $errorMessage) {
            if ($message === $errorMessage->getText()) {
                return true;
            }
        }

        return false;
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'errors' => '.invalid-feedback',
            'brother' => '[data-test-brother]',
            'assignment-date' => '[data-test-assignment-date]',
            'revocation-date' => '[data-test-revocation-date]',
            'territory' => '[data-test-territory]',
            'save' => '[data-test-save]',
        ]);
    }
}
