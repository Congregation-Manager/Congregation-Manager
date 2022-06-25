<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Application\Congregation;

use CongregationManager\Application\Congregation\CreateBrother;
use CongregationManager\Domain\Congregation\Model\Congregation;
use CongregationManager\Domain\Congregation\Repository\BrotherRepositoryInterface;
use CongregationManager\Tests\Repository\BrotherRepository;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateBrotherTest extends TestCase
{
    private BrotherRepositoryInterface $brotherRepository;

    private CreateBrother $createBrother;

    protected function setUp(): void
    {
        $this->brotherRepository = new BrotherRepository();
        $this->createBrother = new CreateBrother($this->brotherRepository);
    }

    public function testThatItCreatesANewBrother(): void
    {
        $congregation = new Congregation('Carrollton');
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
        $this->assertSame((new DateTime('1976-04-23'))->format('d/m/Y'), $brother->getBirthDate()->format('d/m/Y'));
        $this->assertSame((new DateTime('1988-06-12'))->format('d/m/Y'), $brother->getBaptismDate()->format('d/m/Y'));
        $this->assertSame($this->brotherRepository->findAll()->first(), $brother);
    }
}
