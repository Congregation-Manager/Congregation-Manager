<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class CheckEmailPage extends SymfonyPage implements CheckEmailPageInterface
{
    protected static $additionalParameters = [
        '_locale' => 'en',
    ];

    public function getRouteName(): string
    {
        return 'admin_check_email';
    }
}
