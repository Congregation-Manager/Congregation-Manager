<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Behat\Context\Hook\DoctrineORMContext;
use CongregationManager\Behat\Context\Hook\EmailSpoolContext;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->public();

    $services->set('congregation_manager_behat.context.hook.doctrine', DoctrineORMContext::class)
        ->args([service('doctrine.orm.entity_manager')])
    ;

    $services->set('congregation_manager_behat.context.hook.email_spool', EmailSpoolContext::class);
};
