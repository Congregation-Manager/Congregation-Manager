<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App\TerritoryAssignment;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface CreatePageInterface extends SymfonyPageInterface
{
    public function selectBrother(BrotherInterface $brother): void;

    public function isTerritorySelected(TerritoryInterface $territory): bool;

    public function specifyAssignmentDate(\DateTimeImmutable $assignmentDate): void;

    public function specifyRevocationDate(\DateTimeImmutable $revocationDate): void;

    public function save(): void;

    public function hasErrorMessage(string $message): bool;
}
