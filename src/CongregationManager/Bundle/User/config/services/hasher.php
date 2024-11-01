<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\User\Hasher\UserPasswordHasher;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_user.hasher.user_password', UserPasswordHasher::class)
        ->args([service('security.password_hasher')])
    ;
};
