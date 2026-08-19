<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class CongregationManagerCoreBundle extends AbstractBundle
{
    /**
     * @param mixed[] $config
     */
    #[\Override]
    public function loadExtension(array $config, ContainerConfigurator $configurator, ContainerBuilder $container): void
    {
        $configurator->import('../config/services.php');
    }

    /**
     * The schema belongs to the bundle that maps it, so installing the bundle is enough
     * to get the migrations: the application does not have to know where they live.
     */
    #[\Override]
    public function prependExtension(ContainerConfigurator $configurator, ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('doctrine_migrations', [
            'migrations_paths' => [
                'CongregationManager\Bundle\Core\Migrations' => __DIR__ . '/../Migrations',
            ],
        ]);
    }
}
