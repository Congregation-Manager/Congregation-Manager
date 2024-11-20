<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use DateTimeImmutable;

interface AppUserInvitationInterface
{
    public function getCreatedAt(): DateTimeImmutable;

    public function getBrother(): BrotherInterface;

    public function getEmail(): string;

    public function getToken(): string;
}
