<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Behat\Context\Ui\Admin\EmailContext as AdminEmailContext;
use CongregationManager\Behat\Context\Ui\App\AccountContext;
use CongregationManager\Behat\Context\Ui\App\EmailContext as AppEmailContext;
use CongregationManager\Behat\Context\Ui\App\LocaleContext;
use CongregationManager\Behat\Context\Ui\App\TerritoryAssignmentContext;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->public();

    $services->set('congregation_manager_behat.context.ui.app.account', AccountContext::class)
        ->args([
            service('congregation_manager_behat.page.app.login'),
            service('congregation_manager_behat.page.app.dashboard'),
            service('congregation_manager_behat.page.app.forgot_password'),
            service('congregation_manager_behat.page.app.check_email'),
            service('congregation_manager_behat.page.app.reset_password'),
            service('congregation_manager_behat.page.app.profile_update'),
            service('congregation_manager_behat.shared_storage'),
            service('congregation_manager_behat.page.app.change_password'),
            service('congregation_manager_behat.page.app.complete_account'),
            service('congregation_manager_behat.page.app.complete_account_localized'),
        ])
    ;

    $services->set('congregation_manager_behat.context.ui.app.locale', LocaleContext::class)
        ->args([
            service('congregation_manager_behat.page.app.entrypoint'),
            service('congregation_manager_behat.page.app.home'),
            service('congregation_manager_behat.page.app.dashboard'),
        ])
    ;

    $services->set(
        'congregation_manager_behat.context.ui.app.territory',
        \CongregationManager\Behat\Context\Ui\App\TerritoryContext::class
    )
        ->args([service('congregation_manager_behat.page.app.territory_show')])
    ;

    $services->set('congregation_manager_behat.context.ui.app.territory_assignment', TerritoryAssignmentContext::class)
        ->args([
            service('congregation_manager_behat.page.app.territory_assignment_create'),
            service('congregation_manager_behat.page.app.territory_assignment_update'),
            service('translator'),
        ])
    ;

    $services->set(
        'congregation_manager_behat.context.ui.admin.account',
        \CongregationManager\Behat\Context\Ui\Admin\AccountContext::class
    )
        ->args([
            service('congregation_manager_behat.page.admin.login'),
            service('congregation_manager_behat.page.admin.dashboard'),
            service('congregation_manager_behat.page.admin.forgot_password'),
            service('congregation_manager_behat.page.admin.check_email'),
            service('congregation_manager_behat.page.admin.reset_password'),
            service('congregation_manager_behat.shared_storage'),
            service('congregation_manager_behat.page.admin.profile_update'),
            service('congregation_manager_behat.page.admin.change_password'),
            service('congregation_manager_behat.page.admin.brother_show'),
            service('congregation_manager_behat.page.admin.invite_app_user'),
        ])
    ;

    $services->set(
        'congregation_manager_behat.context.ui.admin.locale',
        \CongregationManager\Behat\Context\Ui\Admin\LocaleContext::class
    )
        ->args([service('congregation_manager_behat.page.admin.login')])
    ;

    $services->set('congregation_manager_behat.context.ui.admin.email', AdminEmailContext::class)
        ->args([service('congregation_manager_behat.email_checker'), service('translator')])
    ;

    $services->set('congregation_manager_behat.context.ui.app.email', AppEmailContext::class)
        ->args([service('congregation_manager_behat.email_checker'), service('translator')])
    ;
};
