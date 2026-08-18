<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Congregation\Tests\Command;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

/**
 * @internal
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class CreateCongregationCommandTest extends KernelTestCase
{
    /**
     * @var array<string, string>
     */
    private array $congregationData = [
        'name' => 'Carrollton',
    ];

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $appEntityManager = self::getContainer()->get('doctrine.orm.entity_manager');
        $purger = new ORMPurger($appEntityManager);
        $purger->purge();
    }

    public function testCreateAppUserInteractive(): void
    {
        $this->executeCommand([], array_values($this->congregationData));

        $congregations = self::getContainer()->get(
            'congregation_manager_congregation.repository.congregation'
        )->findAll();
        $this->assertCount(1, $congregations);
        $congregation = $congregations[0];
        $this->assertInstanceOf(CongregationInterface::class, $congregation);
        $this->assertNotNull($congregation->getId());
        $this->assertSame('Carrollton', $congregation->getName());
        $this->assertCount(0, $congregation->getBrothers());
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the execution of a command.
     *
     * @param array<array-key, string> $arguments All the arguments passed when executing the command
     * @param array<array-key, string|null> $inputs    The (optional) answers given to the command when it asks for the value of the missing arguments
     */
    private function executeCommand(array $arguments, array $inputs = []): CommandTester
    {
        self::bootKernel();

        // this uses a special testing container that allows you to fetch private services
        /** @var Command $command */
        $command = self::getContainer()->get('congregation_manager_congregation.command.create_congregation');
        $kernel = self::$kernel;
        Assert::isInstanceOf($kernel, KernelInterface::class);
        $command->setApplication(new Application($kernel));

        $commandTester = new CommandTester($command);
        $commandTester->setInputs($inputs);
        $commandTester->execute($arguments);

        return $commandTester;
    }
}
