<?php

namespace App\Infrastructure\User\Model;

use App\Domain\User\Model\AppUserInterface as DomainAppUserInterface;

interface AppUserInterface extends DomainAppUserInterface, UserInterface
{
}
