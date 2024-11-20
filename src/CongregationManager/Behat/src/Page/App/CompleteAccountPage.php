<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class CompleteAccountPage extends SymfonyPage implements CompleteAccountPageInterface
{
    #[\Override]
    public function getRouteName(): string
    {
        return 'congregation_manager_app_complete_account';
    }
}
