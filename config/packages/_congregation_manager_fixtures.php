<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Locale;

return static function (ContainerConfigurator $containerConfigurator) {
    $containerConfigurator->extension('congregation_manager_fixtures', [
        'admins' => [
            [
                'email' => 'superadmin@email.com',
                'password' => 'superadmin',
                'locale' => Locale::Italian->value,
                'super_admin' => true,
            ],
            [
                'email' => 'admin@email.com',
                'password' => 'adminadmin',
                'locale' => Locale::Italian->value,
                'super_admin' => false,
            ],
        ],
    ]);
};
