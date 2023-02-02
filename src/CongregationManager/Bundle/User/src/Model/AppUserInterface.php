<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Model;

use CongregationManager\Component\User\Domain\AppUserInterface as DomainAppUserInterface;

interface AppUserInterface extends DomainAppUserInterface, UserInterface
{
}
