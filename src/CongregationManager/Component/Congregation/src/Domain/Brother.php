<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain;

use CongregationManager\Contract\Resource\AggregateRoot;
use CongregationManager\Contract\Resource\AggregateRootId;
use DateTimeInterface;

class Brother extends AggregateRoot implements BrotherInterface
{
    public function __construct(
        AggregateRootId $id,
        protected string $firstName,
        protected string $lastName,
        protected CongregationInterface $congregation,
        protected bool $male = true,
        protected ?string $middleName = null,
        protected ?DateTimeInterface $birthDate = null,
        protected ?DateTimeInterface $baptismDate = null,
    ) {
        parent::__construct($id);
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
    public function getSex(): string
    {
        return $this->isMale() ? 'male' : 'female';
    }

    #[\Override]
    public function getFullName(): string
    {
        $middleName = $this->getMiddleName();

        return $this->getFirstName() . ' ' . ($middleName !== null ? $middleName . ' ' : '') . $this->getLastName();
    }
}
