<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App\Territory;

use Behat\Mink\Element\NodeElement;
use DateTimeImmutable;
use DateTimeInterface;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Webmozart\Assert\Assert;

final class ShowPage extends SymfonyPage implements ShowPageInterface
{
    #[\Override]
    public function getRouteName(): string
    {
        return 'app_territory_show';
    }

    #[\Override]
    public function getTerritoryAssignmentsCount(): int
    {
        return count($this->getAllTerritoryAssignments());
    }

    #[\Override]
    public function getFirstTerritoryAssignmentBrother(): string
    {
        $firstTerritoryAssignment = $this->getFirstTerritoryAssignment()
            ->find('css', $this->getDefinedElements()['territory-assignment-brother']);
        Assert::isInstanceOf($firstTerritoryAssignment, NodeElement::class);

        return $firstTerritoryAssignment->getText();
    }

    #[\Override]
    public function getFirstTerritoryAssignmentAssignmentDate(): DateTimeInterface
    {
        $firstTerritoryAssignment = $this->getFirstTerritoryAssignment()
            ->find('css', $this->getDefinedElements()['territory-assignment-assignment-date']);
        Assert::isInstanceOf($firstTerritoryAssignment, NodeElement::class);
        $assignmentDate = $firstTerritoryAssignment->getText();

        return new DateTimeImmutable($assignmentDate);
    }

    #[\Override]
    public function getLastTerritoryAssignmentBrother(): string
    {
        $lastTerritoryAssignment = $this->getLastOneTerritoryAssignment()
            ->find('css', $this->getDefinedElements()['territory-assignment-brother']);
        Assert::isInstanceOf($lastTerritoryAssignment, NodeElement::class);

        return $lastTerritoryAssignment->getText();
    }

    #[\Override]
    public function getLastTerritoryAssignmentAssignmentDate(): DateTimeInterface
    {
        $lastAssignment = $this->getLastOneTerritoryAssignment();
        $lastAssignmentAssignmentDate = $lastAssignment
            ->find('css', $this->getDefinedElements()['territory-assignment-assignment-date']);
        Assert::isInstanceOf($lastAssignmentAssignmentDate, NodeElement::class);
        $assignmentDate = $lastAssignmentAssignmentDate->getText();

        return new DateTimeImmutable($assignmentDate);
    }

    /**
     * @return array<string, string|string[]>
     */
    #[\Override]
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'territory-assignments' => '[data-test-territory-assignment]',
            'territory-assignment-brother' => '[data-test-territory-assignment-brother]',
            'territory-assignment-assignment-date' => '[data-test-territory-assignment-assignment-date]',
        ]);
    }

    /**
     * @return NodeElement[]
     */
    private function getAllTerritoryAssignments(): array
    {
        return $this->getDocument()
            ->findAll('css', $this->getDefinedElements()['territory-assignments'])
        ;
    }

    private function getFirstTerritoryAssignment(): NodeElement
    {
        $territoryAssignments = $this->getAllTerritoryAssignments();
        $firstElement = reset($territoryAssignments);
        Assert::isInstanceOf($firstElement, NodeElement::class);

        return $firstElement;
    }

    private function getLastOneTerritoryAssignment(): NodeElement
    {
        $territoryAssignments = $this->getAllTerritoryAssignments();
        $lastElement = array_pop($territoryAssignments);
        Assert::isInstanceOf($lastElement, NodeElement::class);

        return $lastElement;
    }
}
