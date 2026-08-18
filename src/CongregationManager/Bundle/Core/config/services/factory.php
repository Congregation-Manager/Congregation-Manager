<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Factory\AdminUserFactory;
use CongregationManager\Bundle\Core\Factory\AppUserFactory;
use CongregationManager\Component\Core\Domain\Factory\AreaFactory;
use CongregationManager\Component\Core\Domain\Factory\BrotherFactory;
use CongregationManager\Component\Core\Domain\Factory\CongregationFactory;
use CongregationManager\Component\Core\Domain\Factory\MunicipalityFactory;
use CongregationManager\Component\Core\Domain\Factory\ProvinceFactory;
use CongregationManager\Component\Core\Domain\Factory\TerritoryAssignmentFactory;
use CongregationManager\Component\Core\Domain\Factory\TerritoryFactory;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_congregation.factory.congregation', CongregationFactory::class);

    $services->set('congregation_manager_congregation.factory.brother', BrotherFactory::class);

    $services->set('congregation_manager_territory_manager.factory.province', ProvinceFactory::class)
        ->args([service('congregation_manager_core.context.congregation')])
    ;

    $services->set('congregation_manager_territory_manager.factory.municipality', MunicipalityFactory::class)
        ->args([service('congregation_manager_core.context.congregation')])
    ;

    $services->set('congregation_manager_territory_manager.factory.area', AreaFactory::class)
        ->args([service('congregation_manager_core.context.congregation')])
    ;

    $services->set('congregation_manager_territory_manager.factory.territory', TerritoryFactory::class)
        ->args([service('congregation_manager_core.context.congregation')])
    ;

    $services->set(
        'congregation_manager_territory_manager.factory.territory_assignment',
        TerritoryAssignmentFactory::class
    );

    $services->set('congregation_manager_user.factory.admin_user', AdminUserFactory::class);

    $services->set('congregation_manager_user.factory.app_user', AppUserFactory::class);
};
