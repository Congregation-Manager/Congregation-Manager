<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Entity;

use CongregationManager\Component\Core\Domain\AppResetPasswordRequest as BaseAppResetPasswordRequest;
use CongregationManager\Component\Core\Domain\AppUserInterface;

class AppResetPasswordRequest extends BaseAppResetPasswordRequest
{
    protected \DateTimeImmutable $requestedAt;

    public function __construct(
        \DateTimeInterface $expiresAt,
        string $hashedToken,
        AppUserInterface $user,
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
