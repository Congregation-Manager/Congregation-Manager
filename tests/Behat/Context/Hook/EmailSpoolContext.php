<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Hook;

use Behat\Behat\Context\Context;
use CongregationManager\Tests\Behat\Services\FakeMailerTransport;

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
