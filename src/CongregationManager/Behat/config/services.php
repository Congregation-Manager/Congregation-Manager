<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Behat\Services\BehatMailerFactory;
use CongregationManager\Behat\Services\EmailChecker;
use CongregationManager\Behat\Services\FakeMailerTransport;
use CongregationManager\Behat\Services\SecurityService;
use CongregationManager\Behat\Services\Setter\CookieSetter;
use CongregationManager\Behat\Services\SharedStorage;

return static function (ContainerConfigurator $containerConfigurator) {
    $containerConfigurator->import('services/*.php');

    $services = $containerConfigurator->services();

    $services->set('congregation_manager_behat.setter.cookie', CookieSetter::class)
        ->args([service('behat.mink.default_session')])
    ;

    $services->set('congregation_manager_behat.mailer_factory', BehatMailerFactory::class)
        ->args([service('congregation_manager_behat.mailer_transport')])
        ->tag('mailer.transport_factory')
    ;

    $services->set('congregation_manager_behat.email_checker', EmailChecker::class);

    $services->set('congregation_manager_behat.mailer_transport', FakeMailerTransport::class)
        ->args([service('twig')])
    ;

    $services->set('congregation_manager_behat.security', SecurityService::class)
        ->args([service('session.factory'), service('congregation_manager_behat.setter.cookie'), 'app'])
    ;

    $services->set('congregation_manager_behat.shared_storage', SharedStorage::class);
};
