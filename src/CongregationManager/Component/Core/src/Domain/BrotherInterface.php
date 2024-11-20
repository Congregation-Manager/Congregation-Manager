<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\BrotherInterface as BaseBrotherInterface;
use CongregationManager\Component\TerritoryManager\Domain\RecipientInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use Doctrine\Common\Collections\Collection;

interface BrotherInterface extends BaseBrotherInterface, RecipientInterface
{
    public function getUser(): ?AppUserInterface;

    public function setUser(?AppUserInterface $user): void;

    public function getInvitation(): ?AppUserInvitation;

    public function setInvitation(?AppUserInvitation $invitation): void;

    /**
     * @return Collection<array-key, TerritoryAssignmentInterface>
     */
    public function getTerritoryAssignments(): Collection;

    public function addTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void;

    public function removeTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void;
}
