<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class CongregationManagerAdminBundle extends AbstractBundle
{
    /**
     * @param mixed[] $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->services()
            ->defaults()
            ->autowire(false)
            ->autoconfigure(false)
        ;
        $container->import('../config/services.php');
    }
}
