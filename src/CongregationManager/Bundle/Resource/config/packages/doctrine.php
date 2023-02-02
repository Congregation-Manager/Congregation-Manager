<?php

declare(strict_types=1);

use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine) {
    $doctrine
        ->dbal()
        ->type(
            'integer_aggregate_root_id',
            CongregationManager\Bundle\Resource\Doctrine\DBAL\Types\IntegerAggregateRootIdType::class
        );
};
