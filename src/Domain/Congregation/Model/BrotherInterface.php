<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Model;

use CongregationManager\Domain\User\Model\AppUserInterface;
use CongregationManager\Domain\User\Model\AppUserInvitation;
use DateTimeInterface;

interface BrotherInterface
{
    public function getMiddleName(): ?string;

    public function setMiddleName(?string $middleName): void;

    public function getBirthDate(): ?DateTimeInterface;

    public function setBirthDate(?DateTimeInterface $birthDate): void;

    public function getBaptismDate(): ?DateTimeInterface;

    public function setBaptismDate(?DateTimeInterface $baptismDate): void;

    public function getUser(): ?AppUserInterface;

    public function setUser(?AppUserInterface $user): void;

    public function getFirstName(): string;

    public function setFirstName(string $firstName): void;

    public function getLastName(): string;

    public function setLastName(string $lastName): void;

    public function getCongregation(): CongregationInterface;

    public function setCongregation(CongregationInterface $congregation): void;

    public function isMale(): bool;

    public function setMale(bool $male): void;

    public function getInvitation(): ?AppUserInvitation;

    public function setInvitation(?AppUserInvitation $invitation): void;
}
