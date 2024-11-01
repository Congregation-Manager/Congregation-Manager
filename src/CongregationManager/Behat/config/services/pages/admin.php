<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Behat\Page\Admin\BrotherShowPage;
use CongregationManager\Behat\Page\Admin\ChangePasswordPage;
use CongregationManager\Behat\Page\Admin\CheckEmailPage;
use CongregationManager\Behat\Page\Admin\DashboardPage;
use CongregationManager\Behat\Page\Admin\ForgotPasswordPage;
use CongregationManager\Behat\Page\Admin\InviteAppUserPage;
use CongregationManager\Behat\Page\Admin\LoginPage;
use CongregationManager\Behat\Page\Admin\ProfileUpdatePage;
use CongregationManager\Behat\Page\Admin\ResetPasswordPage;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_behat.page.admin.login', LoginPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.admin.dashboard', DashboardPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.admin.forgot_password', ForgotPasswordPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.admin.check_email', CheckEmailPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.admin.reset_password', ResetPasswordPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.admin.profile_update', ProfileUpdatePage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.admin.change_password', ChangePasswordPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.admin.brother_show', BrotherShowPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;

    $services->set('congregation_manager_behat.page.admin.invite_app_user', InviteAppUserPage::class)
        ->parent('congregation_manager_behat.page.symfony')
    ;
};
