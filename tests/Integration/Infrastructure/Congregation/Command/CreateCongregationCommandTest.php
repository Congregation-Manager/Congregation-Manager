<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Integration\Infrastructure\Congregation\Command;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Tests\Integration\Infrastructure\Common\Command\AbstractCommandTest;

/**
 * @internal
 */
final class CreateCongregationCommandTest extends AbstractCommandTest
{
    private array $congregationData = [
        'name' => 'Carrollton',
    ];

    public function testCreateAppUserInteractive(): void
    {
        $this->executeCommand([], array_values($this->congregationData));

        $congregations = self::getContainer()->get('cm.repository.congregation')->findAll();
        $this->assertCount(1, $congregations);
        $congregation = $congregations[0];
        $this->assertInstanceOf(CongregationInterface::class, $congregation);
        $this->assertNotNull($congregation->getId());
        $this->assertSame('Carrollton', $congregation->getName());
        $this->assertCount(0, $congregation->getBrothers());
    }

    protected function getCommandServiceDefinition(): string
    {
        return 'cm.command.create_congregation';
    }
}
