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
        $this->addAdminDefinitions($definition);
        $this->addCongregationDefinitions($definition);
        $this->addBrotherDefinitions($definition);
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

        $container->services()
            ->get('congregation_manager_fixtures.data_fixtures.congregation')
            ->arg('$congregationFixtureData', $config['congregations'])
        ;

        $container->services()
            ->get('congregation_manager_fixtures.data_fixtures.brother')
            ->arg('$brotherFixtureData', $config['brothers'])
        ;
    }

    public function addAdminDefinitions(DefinitionConfigurator $definition): void
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
                                ->info(
                                    'The locale for the admin user, default is the default locale of the application'
                                )
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

    public function addCongregationDefinitions(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->arrayNode('congregations')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')
                                ->isRequired()
                                ->info('The name of the congregation')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    public function addBrotherDefinitions(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->arrayNode('brothers')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('first_name')
                                ->isRequired()
                                ->info('The first name of the brother/sister')
                            ->end()
                            ->scalarNode('middle_name')
                                ->defaultNull()
                                ->info('The middle name of the brother/sister')
                            ->end()
                            ->scalarNode('last_name')
                                ->isRequired()
                                ->info('The last name of the brother/sister')
                            ->end()
                            ->booleanNode('is_male')
                                ->defaultTrue()
                                ->info('Specifies whether it is a brother or a sister')
                            ->end()
                            ->scalarNode('congregation_name')
                                ->isRequired()
                                ->info('The congregation name of the brother/sister')
                            ->end()
                            ->scalarNode('birth_date')
                                ->defaultNull()
                                ->info('The birth date of the brother/sister')
                            ->end()
                            ->scalarNode('baptism_date')
                                ->defaultNull()
                                ->info('The baptism date of the brother/sister')
                            ->end()
                            ->arrayNode('user')
                                ->children()
                                    ->scalarNode('email')
                                        ->isRequired()
                                        ->info('The email of the user')
                                    ->end()
                                    ->scalarNode('password')
                                        ->defaultValue('password')
                                        ->info('The password of the user')
                                    ->end()
                                    ->scalarNode('locale')
                                        ->defaultNull()
                                        ->info('The locale of the user, default is the default locale of the application')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
