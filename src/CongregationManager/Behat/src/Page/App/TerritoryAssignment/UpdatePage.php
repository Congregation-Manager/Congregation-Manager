<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App\TerritoryAssignment;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class UpdatePage extends SymfonyPage implements UpdatePageInterface
{
    #[\Override]
    public function getRouteName(): string
    {
        return 'app_territory_assignment_update';
    }
}
