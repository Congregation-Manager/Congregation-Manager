<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Hook;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Services\FakeMailerTransport;

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
