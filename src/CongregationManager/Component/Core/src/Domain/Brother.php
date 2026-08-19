<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\Brother as BaseBrother;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Contract\Resource\AggregateRootId;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Brother extends BaseBrother implements BrotherInterface
{
    protected ?AppUserInterface $user = null;

    protected ?AppUserInvitation $invitation = null;

    /**
     * @var Collection<array-key, TerritoryAssignmentInterface>
     */
    protected Collection $territoryAssignments;

    public function __construct(
        AggregateRootId $id,
        string $firstName,
        string $lastName,
        CongregationInterface $congregation,
        bool $male = true,
        ?string $middleName = null,
        ?DateTimeInterface $birthDate = null,
        ?DateTimeInterface $baptismDate = null,
    ) {
        parent::__construct($id, $firstName, $lastName, $congregation, $male, $middleName, $birthDate, $baptismDate);

        $this->territoryAssignments = new ArrayCollection();
    }

    #[\Override]
    public function getUser(): ?AppUserInterface
    {
        return $this->user;
    }

    #[\Override]
    public function setUser(?AppUserInterface $user): void
    {
        $this->user = $user;
    }

    #[\Override]
    public function getInvitation(): ?AppUserInvitation
    {
        return $this->invitation;
    }

    #[\Override]
    public function setInvitation(?AppUserInvitation $invitation): void
    {
        $this->invitation = $invitation;
    }

    #[\Override]
    public function getTerritoryAssignments(): Collection
    {
        return $this->territoryAssignments;
    }

    #[\Override]
    public function addTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if (!$this->territoryAssignments->contains($territoryAssignment)) {
            $this->territoryAssignments->add($territoryAssignment);
        }
    }

    #[\Override]
    public function removeTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if ($this->territoryAssignments->contains($territoryAssignment)) {
            $this->territoryAssignments->removeElement($territoryAssignment);
        }
    }
}
