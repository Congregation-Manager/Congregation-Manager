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
        ])
        ->tag('doctrine.fixture.orm')
    ;

    $services->set('congregation_manager_fixtures.data_fixtures.congregation', CongregationFixtures::class)
        ->tag('doctrine.fixture.orm')
    ;

    $services->set('congregation_manager_fixtures.data_fixtures.brother', BrotherFixtures::class)
        ->args([
            '$defaultLocale' => param('congregation_manager_core.default_locale'),
            '$userPasswordHasher' => service('congregation_manager_user.hasher.user_password'),
        ])
        ->tag('doctrine.fixture.orm')
    ;
};
