<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Behat\Page\App\ChangePasswordPage;
use CongregationManager\Behat\Page\App\CheckEmailPage;
use CongregationManager\Behat\Page\App\CompleteAccountPage;
use CongregationManager\Behat\Page\App\DashboardPage;
use CongregationManager\Behat\Page\App\ForgotPasswordPage;
use CongregationManager\Behat\Page\App\HomePage;
use CongregationManager\Behat\Page\App\LoginPage;
use CongregationManager\Behat\Page\App\ProfileUpdatePage;
use CongregationManager\Behat\Page\App\ResetPasswordPage;
use CongregationManager\Behat\Page\App\Territory\ShowPage;
use CongregationManager\Behat\Page\App\TerritoryAssignment\CreatePage;
use CongregationManager\Behat\Page\App\TerritoryAssignment\UpdatePage;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_behat.page.app.home', HomePage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.login', LoginPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.dashboard', DashboardPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.forgot_password', ForgotPasswordPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.check_email', CheckEmailPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.reset_password', ResetPasswordPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.profile_update', ProfileUpdatePage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.change_password', ChangePasswordPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.complete_account', CompleteAccountPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.territory_assignment_create', CreatePage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.territory_assignment_update', UpdatePage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.app.territory_show', ShowPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;
};
