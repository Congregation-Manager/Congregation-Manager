<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Resource\Controller\ArgumentResolver\AggregateRootIdValueResolver;
use CongregationManager\Bundle\Resource\Uid\UuidGenerator;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_resource.generator.id', UuidGenerator::class);
    $services->alias(IdGeneratorInterface::class, 'congregation_manager_resource.generator.id');

    $services->set(
        'congregation_manager_resource.argument_resolver.aggregate_root_id',
        AggregateRootIdValueResolver::class
    )
        ->tag('controller.argument_value_resolver', [
            'priority' => 150,
        ])
    ;
};
