<?php

namespace App\Infrastructure\User\Model;

use App\Domain\User\Model\ResetPasswordRequestInterface as DomainResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface as SymfonyResetPasswordRequestInterface;

interface ResetPasswordRequestInterface extends DomainResetPasswordRequestInterface, SymfonyResetPasswordRequestInterface
{
}
