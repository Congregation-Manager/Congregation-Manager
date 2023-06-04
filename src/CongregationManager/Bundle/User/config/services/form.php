<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\User\Form\ChangeEmailFormType;
use CongregationManager\Bundle\User\Form\ChangePasswordFormType;
use CongregationManager\Bundle\User\Form\CompleteAccountFormType;
use CongregationManager\Bundle\User\Form\InviteUserFormType;
use CongregationManager\Bundle\User\Form\ResetPasswordRequestFormType;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_user.form.change_email', ChangeEmailFormType::class)
        ->tag('form.type')
    ;

    $services->set('congregation_manager_user.form.change_email', ChangePasswordFormType::class)
        ->tag('form.type')
    ;

    $services->set('congregation_manager_user.form.change_email', CompleteAccountFormType::class)
        ->tag('form.type')
    ;

    $services->set('congregation_manager_user.form.change_email', InviteUserFormType::class)
        ->tag('form.type')
    ;

    $services->set('congregation_manager_user.form.change_email', ResetPasswordRequestFormType::class)
        ->tag('form.type')
    ;
};
