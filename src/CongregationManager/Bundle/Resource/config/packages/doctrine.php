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
        );

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
