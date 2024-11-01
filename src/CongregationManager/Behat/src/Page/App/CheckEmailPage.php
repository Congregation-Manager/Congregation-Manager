<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class CheckEmailPage extends SymfonyPage implements CheckEmailPageInterface
{
    #[\Override]
    public function getRouteName(): string
    {
        return 'congregation_manager_app_check_email';
    }
}
