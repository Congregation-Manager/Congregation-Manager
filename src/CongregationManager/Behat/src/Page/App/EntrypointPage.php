<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class EntrypointPage extends SymfonyPage implements EntrypointPageInterface
{
    /**
     * @var array<string, string>
     */
    protected static $additionalParameters = [];

    #[\Override]
    public function getRouteName(): string
    {
        return 'congregation_manager_app_entrypoint';
    }
}
