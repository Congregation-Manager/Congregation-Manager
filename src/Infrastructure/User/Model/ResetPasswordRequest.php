<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Domain\User\Exception\Factory\UserInstanceNotValidFactory;
use CongregationManager\Domain\User\Model\AdminUserInterface;
use CongregationManager\Domain\User\Model\AppUserInterface;
use CongregationManager\Domain\User\Model\ResetPasswordRequest as DomainResetPasswordRequest;
use CongregationManager\Domain\User\Model\UserInterface;
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
        if (null !== $adminUser) {
            return $adminUser;
        }

        $appUser = $this->getAppUser();
        if (null !== $appUser) {
            return $appUser;
        }

        throw new \LogicException('Unable to determine the user to return.');
    }

    public function getRequestedAt(): DateTimeInterface
    {
        return $this->requestedAt;
    }
}
