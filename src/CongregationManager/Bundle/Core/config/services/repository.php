<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Repository\OldCM\AppUserRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\AreaRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\BrotherRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\CongregationRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\MunicipalityRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\ProvinceRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\TerritoryAssignmentRepository;
use CongregationManager\Bundle\Core\Repository\OldCM\TerritoryRepository;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_core.old_cm.repository.app_user', AppUserRepository::class)
        ->args([service('doctrine.dbal.old_cm_connection')])
    ;

    $services->set('congregation_manager_core.old_cm.repository.area', AreaRepository::class)
        ->args([service('doctrine.dbal.old_cm_connection')])
    ;

    $services->set('congregation_manager_core.old_cm.repository.brother', BrotherRepository::class)
        ->args([service('doctrine.dbal.old_cm_connection')])
    ;

    $services->set('congregation_manager_core.old_cm.repository.congregation', CongregationRepository::class)
        ->args([service('doctrine.dbal.old_cm_connection')])
    ;

    $services->set('congregation_manager_core.old_cm.repository.municipality', MunicipalityRepository::class)
        ->args([service('doctrine.dbal.old_cm_connection')])
    ;

    $services->set('congregation_manager_core.old_cm.repository.province', ProvinceRepository::class)
        ->args([service('doctrine.dbal.old_cm_connection')])
    ;

    $services->set(
        'congregation_manager_core.old_cm.repository.territory_assignment',
        TerritoryAssignmentRepository::class
    )
        ->args([service('doctrine.dbal.old_cm_connection')])
    ;

    $services->set('congregation_manager_core.old_cm.repository.territory', TerritoryRepository::class)
        ->args([service('doctrine.dbal.old_cm_connection')])
    ;
};
