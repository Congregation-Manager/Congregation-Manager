<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Domain\User\Model\ResetPasswordRequestInterface as DomainResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface as SymfonyResetPasswordRequestInterface;

interface ResetPasswordRequestInterface extends DomainResetPasswordRequestInterface, SymfonyResetPasswordRequestInterface
{
}
