<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Locale;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import('@CongregationManagerAppBundle/config/config.php');
    $containerConfigurator->import('@CongregationManagerAdminBundle/config/config.php');

    $containerConfigurator->extension('framework', [
        'default_locale' => Locale::getDefault()->value,
        'enabled_locales' => array_map(static fn(Locale $locale): string => $locale->value, Locale::cases()),
        'translator' => [
            'fallbacks' => [Locale::getDefault()->value],
        ],
    ]);

    $containerConfigurator->parameters()
        ->set('app_admin.path_name', 'admin')
        ->set('supported_locales', implode('|', array_map(static fn(Locale $locale): string => $locale->value, Locale::cases())))
    ;

    if ('test' === $containerConfigurator->env()) {
        $containerConfigurator->extension('framework', [
            'default_locale' => 'en_US',
            'enabled_locales' => ['en_US' , 'it_IT'],
            'translator' => [
                'fallbacks' => ['en_US'],
            ],
        ]);

        $containerConfigurator->parameters()
            ->set('supported_locales', 'en_US|it_IT')
        ;
    }
};
