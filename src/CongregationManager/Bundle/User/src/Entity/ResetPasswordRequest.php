<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Entity;

use CongregationManager\Component\User\Domain\ResetPasswordRequest as DomainResetPasswordRequest;
use CongregationManager\Component\User\Domain\UIUserInterface;
use DateTimeImmutable;
use DateTimeInterface;

class ResetPasswordRequest extends DomainResetPasswordRequest implements ResetPasswordRequestInterface
{
    protected DateTimeImmutable $requestedAt;

    public function __construct(
        UIUserInterface $user,
        DateTimeInterface $expiresAt,
        protected string $selector,
        protected string $hashedToken
    ) {
        parent::__construct($expiresAt, $hashedToken, $user);
        $this->requestedAt = new DateTimeImmutable('now');
    }

    #[\Override]
    public function getRequestedAt(): DateTimeInterface
    {
        return $this->requestedAt;
    }

    #[\Override]
    public function getUser(): object
    {
        return $this->getUiUser();
    }
}
