<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Model;

use CongregationManager\Bundle\User\Entity\AppUserInterface;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;

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
