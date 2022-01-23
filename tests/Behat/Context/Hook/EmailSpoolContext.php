<?php

namespace App\Tests\Behat\Context\Hook;

use App\Tests\Behat\Services\FakeMailerTransport;
use Behat\Behat\Context\Context;

final class EmailSpoolContext implements Context
{
    /**
     * @BeforeScenario @email
     */
    public function purgeSentMessages(): void
    {
        FakeMailerTransport::$sentMessages = [];
    }
}
