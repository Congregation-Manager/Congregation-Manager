<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Integration\Infrastructure\Congregation\Command;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Tests\Integration\Infrastructure\Common\Command\AbstractCommandTest;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class CreateCongregationCommandTest extends AbstractCommandTest
{
    private array $congregationData = [
        'name' => 'Carrollton',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $appEntityManager = self::getContainer()->get('doctrine.orm.entity_manager');
        $purger = new ORMPurger($appEntityManager);
        $purger->purge();
    }

    public function testCreateAppUserInteractive(): void
    {
        $this->executeCommand(
            [],
            array_values($this->congregationData)
        );

        $congregations = self::getContainer()->get('cm.repository.congregation')->findAll();
        $this->assertCount(1, $congregations);
        $congregation = $congregations[0];
        $this->assertInstanceOf(CongregationInterface::class, $congregation);
        $this->assertNotNull($congregation->getId());
        $this->assertEquals('Carrollton', $congregation->getName());
        $this->assertCount(0, $congregation->getBrothers());
    }

    protected function getCommandServiceDefinition(): string
    {
        return 'cm.command.create_congregation';
    }
}
