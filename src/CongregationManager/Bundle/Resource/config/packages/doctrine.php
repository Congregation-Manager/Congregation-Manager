<?php

declare(strict_types=1);

use Symfony\Config\Doctrine\Orm\EntityManagerConfig\MappingConfig;
use Symfony\Config\DoctrineConfig;

/** @psalm-suppress UndefinedClass */
return static function (DoctrineConfig $doctrine): void {
    $doctrine
        ->dbal()
        ->type(
            'integer_aggregate_root_id',
            CongregationManager\Bundle\Resource\Doctrine\DBAL\Types\IntegerAggregateRootIdType::class
        )
        ->type(
            'uuid_aggregate_root_id',
            CongregationManager\Bundle\Resource\Doctrine\DBAL\Types\UuidAggregateRootIdType::class
        );

    // so that schema introspection maps a uuid column back onto the custom type
    $doctrine
        ->dbal()
        ->connection('default')
        ->mappingType('uuid', 'uuid_aggregate_root_id');

    $emDefault = $doctrine->orm()
        ->entityManager('default');
    /** @var MappingConfig $mapping */
    $mapping = $emDefault->mapping('CongregationManagerResourceContract');
    $mapping
        ->isBundle(false)
        ->type('xml')
        ->dir('%kernel.project_dir%/src/CongregationManager/Bundle/Resource/config/contract-doctrine')
        ->prefix('CongregationManager\Contract\Resource')
    ;
};
