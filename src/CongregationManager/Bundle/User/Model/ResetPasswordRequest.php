<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Component\User\Domain\AdminUserInterface;
use CongregationManager\Component\User\Domain\AppUserInterface;
use CongregationManager\Component\User\Domain\Exception\Factory\UserInstanceNotValidFactory;
use CongregationManager\Component\User\Domain\ResetPasswordRequest as DomainResetPasswordRequest;
use CongregationManager\Component\User\Domain\UserInterface;
use DateTimeImmutable;
use DateTimeInterface;

class ResetPasswordRequest extends DomainResetPasswordRequest implements ResetPasswordRequestInterface
{
    protected DateTimeImmutable $requestedAt;

    public function __construct(
        UserInterface $user,
        DateTimeInterface $expiresAt,
        protected string $selector,
        protected string $hashedToken
    ) {
        if ($user instanceof AdminUserInterface) {
            parent::__construct($expiresAt, $hashedToken, null, $user);
        } elseif ($user instanceof AppUserInterface) {
            parent::__construct($expiresAt, $hashedToken, $user, null);
        } else {
            throw UserInstanceNotValidFactory::createWithInstanceClass(get_class($user));
        }

        $this->requestedAt = new DateTimeImmutable('now');
    }

    public function getUser(): object
    {
        $adminUser = $this->getAdminUser();
        if ($adminUser !== null) {
            return $adminUser;
        }

        $appUser = $this->getAppUser();
        if ($appUser !== null) {
            return $appUser;
        }

        throw new \LogicException('Unable to determine the user to return.');
    }

    public function getRequestedAt(): DateTimeInterface
    {
        return $this->requestedAt;
    }
}
