<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\App\Territory;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ShowPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_territory_show';
    }
}
