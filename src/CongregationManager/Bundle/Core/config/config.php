<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator) {
    $containerConfigurator->import('@CongregationManagerCongregationBundle/config/config.php');
    $containerConfigurator->import('@CongregationManagerResourceBundle/config/config.php');
    $containerConfigurator->import('@CongregationManagerTerritoryManagerBundle/config/config.php');
    $containerConfigurator->import('@CongregationManagerUserBundle/config/config.php');
};
