<?php

declare(strict_types=1);

use Symfony\Config\SymfonycastsResetPasswordConfig;

return static function (SymfonycastsResetPasswordConfig $symfonycastsResetPasswordConfig): void {
    $symfonycastsResetPasswordConfig
        ->requestPasswordRepository('congregation_manager_user.repository.reset_password_request')
    ;
};
