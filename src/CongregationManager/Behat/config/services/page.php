<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import('pages/*.php');

    $services = $containerConfigurator->services();

    $services->set('congregation_manager_behat.page.symfony', SymfonyPage::class)
        ->abstract()
        ->args([service('behat.mink.default_session'), service('behat.mink.parameters'), service('router')])
    ;
};
