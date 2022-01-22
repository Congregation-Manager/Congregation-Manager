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
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface as SymfonyResetPasswordRequestInterface;

class ResetPasswordRequest extends DomainResetPasswordRequest implements SymfonyResetPasswordRequestInterface
{
    protected DateTimeImmutable $requestedAt;

    /**
     * @throws UserInstanceNotValid
     */
    public function __construct(
        UserInterface $user,
        DateTimeInterface $expiresAt,
        protected string $hashedToken,
        protected string $selector
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
        if ($this->getAdminUser() !== null) {
            return $this->getAdminUser();
        }

        if ($this->getAppUser() !== null) {
            return $this->getAppUser();
        }

        throw new \LogicException('Unable to determine the user to return.');
    }

    public function getRequestedAt(): DateTimeInterface
    {
        return $this->requestedAt;
    }
}
