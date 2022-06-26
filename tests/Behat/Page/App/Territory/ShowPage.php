<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\App\Territory;

use Behat\Mink\Element\NodeElement;
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
        return count($this->getAllTerritoryAssignments());
    }

    public function getFirstTerritoryAssignmentBrother(): string
    {
        return $this->getFirstTerritoryAssignment()
            ->find('css', $this->getDefinedElements()['territory-assignment-brother'])->getText();
    }

    public function getFirstTerritoryAssignmentAssignmentDate(): DateTimeInterface
    {
        $firstAssignment = $this->getFirstTerritoryAssignment();
        $assignmentDate = $firstAssignment
            ->find('css', $this->getDefinedElements()['territory-assignment-assignment-date'])->getText();

        return new DateTimeImmutable($assignmentDate);
    }

    public function getLastTerritoryAssignmentBrother(): string
    {
        return $this->getLastOneTerritoryAssignment()
            ->find('css', $this->getDefinedElements()['territory-assignment-brother'])->getText();
    }

    public function getLastTerritoryAssignmentAssignmentDate(): DateTimeInterface
    {
        $lastAssignment = $this->getLastOneTerritoryAssignment();
        $assignmentDate = $lastAssignment
            ->find('css', $this->getDefinedElements()['territory-assignment-assignment-date'])->getText();

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

    private function getAllTerritoryAssignments(): array
    {
        return $this->getDocument()
            ->findAll('css', $this->getDefinedElements()['territory-assignments'])
        ;
    }

    private function getFirstTerritoryAssignment(): NodeElement
    {
        $territoryAssignments = $this->getAllTerritoryAssignments();

        return reset($territoryAssignments);
    }

    private function getLastOneTerritoryAssignment(): NodeElement
    {
        $territoryAssignments = $this->getAllTerritoryAssignments();

        return array_pop($territoryAssignments);
    }
}
