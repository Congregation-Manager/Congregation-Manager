<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Enum\Locale;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->parameters()
        ->set('congregation_manager_admin.path_name', 'admin')
    ;

    $containerConfigurator->import('@CongregationManagerCoreBundle/config/config.php');
    $containerConfigurator->import('packages/*.php');
};
