<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\EventSubscriber\LocaleSubscriber;
use CongregationManager\Bundle\Core\EventSubscriber\UserLocaleSubscriber;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_core.event_subscriber.locale', LocaleSubscriber::class)
        ->args([param('default_locale'), param('supported_locales')])
        ->tag('kernel.event_subscriber')
    ;

    $services->set('congregation_manager_core.event_subscriber.user_locale', UserLocaleSubscriber::class)
        ->args([service('request_stack'), param('supported_locales')])
        ->tag('kernel.event_subscriber')
    ;
};
