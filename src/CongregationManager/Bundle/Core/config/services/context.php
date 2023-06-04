<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Context\CongregationContext;
use CongregationManager\Bundle\Core\Context\LocaleContext;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_core.context.congregation', CongregationContext::class)
        ->args([service('security.helper')])
    ;

    $services->set('congregation_manager_core.context.locale', LocaleContext::class)
        ->args([service('request_stack')])
    ;
};
