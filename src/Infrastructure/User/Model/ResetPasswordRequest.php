<?php

namespace App\Infrastructure\User\Model;

use App\Domain\User\Exception\Factory\UserInstanceNotValidFactory;
use App\Domain\User\Exception\UserInstanceNotValid;
use App\Domain\User\Model\AdminUserInterface;
use App\Domain\User\Model\AppUserInterface;
use App\Domain\User\Model\ResetPasswordRequest as DomainResetPasswordRequest;
use App\Domain\User\Model\UserInterface;
use DateTimeImmutable;
use DateTimeInterface;

class ResetPasswordRequest extends DomainResetPasswordRequest implements ResetPasswordRequestInterface
{
    protected DateTimeImmutable $requestedAt;

    /**
     * @throws UserInstanceNotValid
     */
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
