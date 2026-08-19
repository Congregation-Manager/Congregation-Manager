<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\User\Domain\ResetPasswordRequest;
use CongregationManager\Contract\Resource\AggregateRootId;
use DateTimeInterface;

class AdminResetPasswordRequest extends ResetPasswordRequest implements AdminResetPasswordRequestInterface
{
    public function __construct(
        AggregateRootId $id,
        DateTimeInterface $expiresAt,
        string $hashedToken,
        AdminUserInterface $user
    ) {
        parent::__construct($id, $expiresAt, $hashedToken, $user);
    }

    #[\Override]
    public function getAdminUser(): AdminUserInterface
    {
        $user = $this->getUiUser();
        if (!$user instanceof AdminUserInterface) {
            throw new \LogicException('User must be an instance of AdminUserInterface');
        }

        return $user;
    }
}
