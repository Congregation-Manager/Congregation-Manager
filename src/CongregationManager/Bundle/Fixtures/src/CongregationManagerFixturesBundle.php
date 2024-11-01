<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\FixturesBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class CongregationManagerFixturesBundle extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
            ->arrayNode('admins')
            ->arrayPrototype()
            ->children()
            ->scalarNode('email')
            ->isRequired()
            ->info('The email for the admin user')
            ->end()
            ->scalarNode('password')
            ->defaultValue('adminadmin')
            ->info('The password for the admin user, default is "adminadmin"')
            ->end()
            ->scalarNode('locale')
            ->defaultNull()
            ->info('The locale for the admin user, default is the default locale of the application')
            ->end()
            ->booleanNode('super_admin')
            ->defaultFalse()
            ->info('Whether the admin user should be a super admin')
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
        ;
    }

    /**
     * @param mixed[] $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.php');

        $container->services()
            ->get('congregation_manager_fixtures.data_fixtures.admin')
            ->arg('$adminFixtureData', $config['admins'])
        ;
    }
}
