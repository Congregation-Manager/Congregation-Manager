<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Model;

use CongregationManager\Component\User\Domain\ResetPasswordRequestInterface as DomainResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface as SymfonyResetPasswordRequestInterface;

interface ResetPasswordRequestInterface extends DomainResetPasswordRequestInterface, SymfonyResetPasswordRequestInterface
{
}
