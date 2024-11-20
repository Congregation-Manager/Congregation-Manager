<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Entity;

use CongregationManager\Component\Core\Domain\AdminResetPasswordRequest as BaseAdminResetPasswordRequest;
use CongregationManager\Component\Core\Domain\AdminUserInterface;

class AdminResetPasswordRequest extends BaseAdminResetPasswordRequest
{
    protected \DateTimeImmutable $requestedAt;

    public function __construct(
        \DateTimeInterface $expiresAt,
        string $hashedToken,
        AdminUserInterface $user,
        protected string $selector,
    ) {
        parent::__construct($expiresAt, $hashedToken, $user);

        $this->requestedAt = new \DateTimeImmutable('now');
    }

    public function getRequestedAt(): \DateTimeImmutable
    {
        return $this->requestedAt;
    }
}
