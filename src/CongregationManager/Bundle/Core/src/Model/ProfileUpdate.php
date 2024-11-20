<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Model;

use CongregationManager\Bundle\Core\Entity\AppUIUserInterface;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;

final class ProfileUpdate
{
    public function __construct(
        private BrotherInterface $brother,
        private AppUIUserInterface $appUser
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

    public function getAppUser(): AppUIUserInterface
    {
        return $this->appUser;
    }

    public function setAppUser(AppUIUserInterface $appUser): void
    {
        $this->appUser = $appUser;
    }
}
