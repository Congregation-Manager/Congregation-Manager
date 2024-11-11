<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\App\Notificator\EmailMessageNotificator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_app.notificator.email_message', EmailMessageNotificator::class)
        ->args([service('mailer'), service('translator'), 'no-reply@congregation-manager.org'])
    ;

    $services->alias(
        'congregation_manager_app.notificator.message',
        'congregation_manager_app.notificator.email_message'
    );
};
