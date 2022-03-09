<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Model;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Infrastructure\User\Model\AppUserInterface;

final class ProfileUpdate
{
    public function __construct(
        private BrotherInterface $brother,
        private AppUserInterface $appUser
    ) {
    }

    public function getBrother(): BrotherInterface
    {
        return $this->brother;
    }

    public function setBrother(BrotherInterface $brother): void
    {
        $this->brother = $brother;
    }

    public function getAppUser(): AppUserInterface
    {
        return $this->appUser;
    }

    public function setAppUser(AppUserInterface $appUser): void
    {
        $this->appUser = $appUser;
    }
}
