<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Tests\Application;

use CongregationManager\Component\Congregation\Application\CreateBrother;
use CongregationManager\Component\Congregation\Domain\Congregation;
use CongregationManager\Component\Congregation\Domain\Factory\BrotherFactory;
use CongregationManager\Component\Congregation\Domain\Repository\BrotherRepositoryInterface;
use CongregationManager\Component\Congregation\Infrastructure\Repository\InMemory\BrotherRepository;
use CongregationManager\Contract\Resource\IncrementingIdGenerator;
use CongregationManager\Contract\Resource\IntegerAggregateRootId;
use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateBrotherTest extends TestCase
{
    private BrotherRepositoryInterface $brotherRepository;

    private CreateBrother $createBrother;

    #[\Override]
    protected function setUp(): void
    {
        $this->brotherRepository = new BrotherRepository();
        $this->createBrother = new CreateBrother(new BrotherFactory(
            new IncrementingIdGenerator()
        ), $this->brotherRepository);
    }

    public function testThatItCreatesANewBrother(): void
    {
        $congregation = new Congregation(new IntegerAggregateRootId(1), 'Carrollton');
        $brother = $this->createBrother->create(
            'Samuel',
            'Finch',
            $congregation,
            true,
            'Junior',
            new DateTime('1976-04-23'),
            new DateTime('1988-06-12')
        );

        $this->assertSame('Samuel', $brother->getFirstName());
        $this->assertSame('Finch', $brother->getLastName());
        $this->assertSame('Junior', $brother->getMiddleName());
        $this->assertSame($congregation, $brother->getCongregation());
        $this->assertTrue($brother->isMale());
        $birthDate = $brother->getBirthDate();
        self::assertInstanceOf(DateTimeInterface::class, $birthDate);
        $this->assertSame((new DateTime('1976-04-23'))->format('d/m/Y'), $birthDate->format('d/m/Y'));
        $baptismDate = $brother->getBaptismDate();
        self::assertInstanceOf(DateTimeInterface::class, $baptismDate);
        $this->assertSame((new DateTime('1988-06-12'))->format('d/m/Y'), $baptismDate->format('d/m/Y'));
        $brothers = $this->brotherRepository->findAll();
        $this->assertSame(reset($brothers), $brother);
    }
}
