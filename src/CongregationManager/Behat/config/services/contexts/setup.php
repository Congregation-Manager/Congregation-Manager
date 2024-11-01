<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Behat\Context\Setup\AccountContext;
use CongregationManager\Behat\Context\Setup\BrotherContext;
use CongregationManager\Behat\Context\Setup\BrowserContext;
use CongregationManager\Behat\Context\Setup\CongregationContext;
use CongregationManager\Behat\Context\Setup\TerritoryAssignmentContext;
use CongregationManager\Behat\Context\Setup\TerritoryContext;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->public();

    $services->set('congregation_manager_behat.context.setup.account', AccountContext::class)
        ->args([
            service('doctrine.orm.entity_manager'),
            service('security.password_hasher'),
            service('symfonycasts.reset_password.token_generator'),
            service('congregation_manager_behat.shared_storage'),
            service('congregation_manager_user.repository.reset_password_request'),
            service('congregation_manager_core.converter.locale'),
            service('congregation_manager_user.create.app_user_invitation'),
            service('congregation_manager_behat.security'),
        ])
    ;

    $services->set('congregation_manager_behat.context.setup.browser', BrowserContext::class)
        ->args([service('behat.mink.default_session'), service('congregation_manager_core.converter.locale')])
    ;

    $services->set('congregation_manager_behat.context.setup.congregation', CongregationContext::class)
        ->args([service('doctrine.orm.entity_manager'), service('congregation_manager_behat.shared_storage')])
    ;

    $services->set('congregation_manager_behat.context.setup.brother', BrotherContext::class)
        ->args([service('doctrine.orm.entity_manager'), service('congregation_manager_behat.shared_storage')])
    ;

    $services->set('congregation_manager_behat.context.setup.territory', TerritoryContext::class)
        ->args([
            service('congregation_manager_behat.shared_storage'),
            service('congregation_manager_territory_manager.repository.territory'),
            service('doctrine.orm.entity_manager'),
        ])
    ;

    $services->set('congregation_manager_behat.context.setup.territory_assignment', TerritoryAssignmentContext::class)
        ->args([
            service('congregation_manager_behat.shared_storage'),
            service('congregation_manager_territory_manager.repository.territory_assignment'),
            service('doctrine.orm.entity_manager'),
        ])
    ;
};
