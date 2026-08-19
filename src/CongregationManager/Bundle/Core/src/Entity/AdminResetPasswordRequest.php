<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Entity;

use CongregationManager\Bundle\User\Entity\ResetPasswordRequestInterface;
use CongregationManager\Component\Core\Domain\AdminResetPasswordRequest as BaseAdminResetPasswordRequest;
use CongregationManager\Component\Core\Domain\AdminUserInterface;
use CongregationManager\Contract\Resource\AggregateRootId;

class AdminResetPasswordRequest extends BaseAdminResetPasswordRequest implements ResetPasswordRequestInterface
{
    protected \DateTimeImmutable $requestedAt;

    public function __construct(
        AggregateRootId $id,
        \DateTimeInterface $expiresAt,
        string $hashedToken,
        AdminUserInterface $user,
        protected string $selector,
    ) {
        parent::__construct($id, $expiresAt, $hashedToken, $user);

        $this->requestedAt = new \DateTimeImmutable('now');
    }

    #[\Override]
    public function getRequestedAt(): \DateTimeImmutable
    {
        return $this->requestedAt;
    }

    #[\Override]
    public function getUser(): object
    {
        return $this->getUiUser();
    }

    public function getSelector(): string
    {
        return $this->selector;
    }
}
