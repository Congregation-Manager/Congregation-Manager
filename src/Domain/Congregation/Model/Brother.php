<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\User\Model\AppUserInterface;
use DateTimeInterface;

class Brother extends AggregateRoot implements BrotherInterface
{
    protected ?string $middleName = null;

    protected ?DateTimeInterface $birthDate = null;

    protected ?DateTimeInterface $baptismDate = null;

    protected ?AppUserInterface $user = null;

    protected bool $male = true;

    public function __construct(
        protected string $firstName,
        protected string $lastName,
        protected CongregationInterface $congregation
    ) {
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getBaptismDate(): ?DateTimeInterface
    {
        return $this->baptismDate;
    }

    public function setBaptismDate(?DateTimeInterface $baptismDate): void
    {
        $this->baptismDate = $baptismDate;
    }

    public function getUser(): ?AppUserInterface
    {
        return $this->user;
    }

    public function setUser(?AppUserInterface $user): void
    {
        $this->user = $user;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getCongregation(): CongregationInterface
    {
        return $this->congregation;
    }

    public function setCongregation(CongregationInterface $congregation): void
    {
        $this->congregation = $congregation;
    }

    public function isMale(): bool
    {
        return $this->male;
    }

    public function setMale(bool $male): void
    {
        $this->male = $male;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s%s %s',
            $this->firstName,
            $this->middleName !== null ? ' ' . $this->middleName : '',
            $this->lastName
        );
    }
}
