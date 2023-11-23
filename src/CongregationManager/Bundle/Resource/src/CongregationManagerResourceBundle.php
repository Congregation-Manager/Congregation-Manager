<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource;

use CongregationManager\Component\Resource\Persister\ResourcePersister;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class CongregationManagerResourceBundle extends AbstractBundle
{
    /**
     * @param mixed[] $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.php');

        foreach (['congregation'] as $resource) {
            $this->addResourceServices($resource, $container);
        }
    }

    private function addResourceServices(string $resource, ContainerConfigurator $container): void
    {
        $services = $container->services();
        $services->set(
            sprintf('congregation_manager_resource.%s.repository', $resource),
            ResourceRepository::class,
        )->args([]);

        $services->set(
            sprintf('congregation_manager_resource.%s.persister', $resource),
            ResourcePersister::class,
        )->args([]);
    }
}
