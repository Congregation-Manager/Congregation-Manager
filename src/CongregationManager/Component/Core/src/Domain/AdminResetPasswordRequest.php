<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\User\Domain\ResetPasswordRequest;
use DateTimeInterface;

class AdminResetPasswordRequest extends ResetPasswordRequest implements AdminResetPasswordRequestInterface
{
    public function __construct(DateTimeInterface $expiresAt, string $hashedToken, AdminUserInterface $user)
    {
        parent::__construct($expiresAt, $hashedToken, $user);
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
