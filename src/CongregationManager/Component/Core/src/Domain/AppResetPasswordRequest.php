<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\User\Domain\ResetPasswordRequest;
use CongregationManager\Contract\Resource\AggregateRootId;
use DateTimeInterface;

class AppResetPasswordRequest extends ResetPasswordRequest implements AppResetPasswordRequestInterface
{
    public function __construct(
        AggregateRootId $id,
        DateTimeInterface $expiresAt,
        string $hashedToken,
        AppUserInterface $user
    ) {
        parent::__construct($id, $expiresAt, $hashedToken, $user);
    }

    #[\Override]
    public function getAppUser(): AppUserInterface
    {
        $user = $this->getUiUser();
        if (!$user instanceof AppUserInterface) {
            throw new \LogicException('User must be an instance of AppUserInterface');
        }

        return $user;
    }
}
