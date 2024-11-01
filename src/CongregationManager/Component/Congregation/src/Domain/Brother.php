<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain;

use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\User\Domain\AppUserInterface;
use CongregationManager\Component\User\Domain\AppUserInvitation;
use CongregationManager\Contract\Resource\AggregateRoot;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Brother extends AggregateRoot implements BrotherInterface
{
    protected ?AppUserInterface $user = null;

    /**
     * @var Collection<array-key, TerritoryAssignmentInterface>
     */
    protected Collection $territoryAssignments;

    public function __construct(
        protected string $firstName,
        protected string $lastName,
        protected CongregationInterface $congregation,
        protected bool $male = true,
        protected ?string $middleName = null,
        protected ?DateTimeInterface $birthDate = null,
        protected ?DateTimeInterface $baptismDate = null,
        protected ?AppUserInvitation $invitation = null
    ) {
        $this->territoryAssignments = new ArrayCollection();
    }

    #[\Override]
    public function __toString(): string
    {
        return sprintf(
            '%s%s %s',
            $this->firstName,
            $this->middleName !== null ? ' ' . $this->middleName : '',
            $this->lastName
        );
    }

    #[\Override]
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    #[\Override]
    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    #[\Override]
    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    #[\Override]
    public function setBirthDate(?DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    #[\Override]
    public function getBaptismDate(): ?DateTimeInterface
    {
        return $this->baptismDate;
    }

    #[\Override]
    public function setBaptismDate(?DateTimeInterface $baptismDate): void
    {
        $this->baptismDate = $baptismDate;
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
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    #[\Override]
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    #[\Override]
    public function getLastName(): string
    {
        return $this->lastName;
    }

    #[\Override]
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    #[\Override]
    public function getCongregation(): CongregationInterface
    {
        return $this->congregation;
    }

    #[\Override]
    public function setCongregation(CongregationInterface $congregation): void
    {
        $this->congregation = $congregation;
    }

    #[\Override]
    public function isMale(): bool
    {
        return $this->male;
    }

    #[\Override]
    public function setMale(bool $male): void
    {
        $this->male = $male;
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

    /**
     * @return Collection<array-key, TerritoryAssignmentInterface>
     */
    public function getTerritoryAssignments(): Collection
    {
        return $this->territoryAssignments;
    }

    public function addTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if (!$this->territoryAssignments->contains($territoryAssignment)) {
            $this->territoryAssignments->add($territoryAssignment);
        }
    }

    public function removeTerritoryAssignment(TerritoryAssignmentInterface $territoryAssignment): void
    {
        if ($this->territoryAssignments->contains($territoryAssignment)) {
            $this->territoryAssignments->removeElement($territoryAssignment);
        }
    }

    public function getFullName(): string
    {
        $middleName = $this->getMiddleName();

        return $this->getFirstName() . ' ' . ($middleName !== null ? $middleName . ' ' : '') . $this->getLastName();
    }
}
