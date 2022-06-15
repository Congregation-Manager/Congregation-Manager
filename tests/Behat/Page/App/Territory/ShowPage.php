<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\App\Territory;

use DateTimeImmutable;
use DateTimeInterface;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ShowPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_territory_show';
    }

    public function getTerritoryAssignmentsCount(): int
    {
        return count($this->getDocument()->findAll('css', $this->getDefinedElements()['territory-assignments']));
    }

    public function getFirstTerritoryAssignmentBrother(): string
    {
        return $this->getElement('territory-assignments')->find('css', $this->getDefinedElements()['territory-assignment-brother'])->getText();
    }

    public function getFirstTerritoryAssignmentAssignmentDate(): DateTimeInterface
    {
        $assignmentDate = $this->getElement('territory-assignments')->find('css', $this->getDefinedElements()['territory-assignment-assignment-date'])->getText();

        return new DateTimeImmutable($assignmentDate);
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'territory-assignments' => '[data-test-territory-assignment]',
            'territory-assignment-brother' => '[data-test-territory-assignment-brother]',
            'territory-assignment-assignment-date' => '[data-test-territory-assignment-assignment-date]',
        ]);
    }
}
