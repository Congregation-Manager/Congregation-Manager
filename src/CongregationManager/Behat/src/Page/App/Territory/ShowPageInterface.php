<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App\Territory;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ShowPageInterface extends SymfonyPageInterface
{
    public function getTerritoryAssignmentsCount(): int;

    public function getFirstTerritoryAssignmentBrother(): string;

    public function getFirstTerritoryAssignmentAssignmentDate(): \DateTimeInterface;

    public function getLastTerritoryAssignmentBrother(): string;

    public function getLastTerritoryAssignmentAssignmentDate(): \DateTimeInterface;
}
