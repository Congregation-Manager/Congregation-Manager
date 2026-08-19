<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Entity;

use CongregationManager\Bundle\User\Entity\ResetPasswordRequestInterface;
use CongregationManager\Component\Core\Domain\AppResetPasswordRequest as BaseAppResetPasswordRequest;
use CongregationManager\Component\Core\Domain\AppUserInterface;
use CongregationManager\Contract\Resource\AggregateRootId;

class AppResetPasswordRequest extends BaseAppResetPasswordRequest implements ResetPasswordRequestInterface
{
    protected \DateTimeImmutable $requestedAt;

    public function __construct(
        AggregateRootId $id,
        \DateTimeInterface $expiresAt,
        string $hashedToken,
        AppUserInterface $user,
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
