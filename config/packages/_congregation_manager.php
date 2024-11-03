<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import('@CongregationManagerAppBundle/config/config.php');
    $containerConfigurator->import('@CongregationManagerAdminBundle/config/config.php');
};
