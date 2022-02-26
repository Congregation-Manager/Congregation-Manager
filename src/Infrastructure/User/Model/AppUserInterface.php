<?php

namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Domain\User\Model\AppUserInterface as DomainAppUserInterface;

interface AppUserInterface extends DomainAppUserInterface, UserInterface
{
}
