<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Bundle\Core\Form\ProfileUpdateFormType;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set('congregation_manager_core.form.profile_update', ProfileUpdateFormType::class)
        ->tag('form.type')
    ;
};
