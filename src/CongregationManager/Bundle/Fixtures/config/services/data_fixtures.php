<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\FixturesBundle\DataFixtures\AdminFixtures;
use CongregationManager\Bundle\FixturesBundle\DataFixtures\BrotherFixtures;
use CongregationManager\Bundle\FixturesBundle\DataFixtures\CongregationFixtures;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_fixtures.data_fixtures.admin', AdminFixtures::class)
        ->args([
            '$defaultLocale' => param('congregation_manager_core.default_locale'),
            '$userPasswordHasher' => service('congregation_manager_user.hasher.user_password'),
            '$adminUserFactory' => service('congregation_manager_user.factory.admin_user'),
        ])
        ->tag('doctrine.fixture.orm')
    ;

    $services->set('congregation_manager_fixtures.data_fixtures.congregation', CongregationFixtures::class)
        ->args([
            '$congregationFactory' => service('congregation_manager_congregation.factory.congregation'),
        ])
        ->tag('doctrine.fixture.orm')
    ;

    $services->set('congregation_manager_fixtures.data_fixtures.brother', BrotherFixtures::class)
        ->args([
            '$defaultLocale' => param('congregation_manager_core.default_locale'),
            '$userPasswordHasher' => service('congregation_manager_user.hasher.user_password'),
            '$brotherFactory' => service('congregation_manager_congregation.factory.brother'),
            '$appUserFactory' => service('congregation_manager_user.factory.app_user'),
        ])
        ->tag('doctrine.fixture.orm')
    ;
};
