<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Application\Congregation;

use CongregationManager\Application\Congregation\CreateBrother;
use CongregationManager\Domain\Congregation\Model\Congregation;
use CongregationManager\Domain\Congregation\Repository\BrotherRepositoryInterface;
use CongregationManager\Tests\Repository\BrotherRepository;
use DateTime;
use PHPUnit\Framework\TestCase;

class CreateBrotherTest extends TestCase
{
    private BrotherRepositoryInterface $brotherRepository;

    private CreateBrother $createBrother;

    protected function setUp(): void
    {
        $this->brotherRepository = new BrotherRepository();
        $this->createBrother = new CreateBrother($this->brotherRepository);
    }

    public function test_that_it_creates_a_new_brother(): void
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

        $this->assertEquals('Samuel', $brother->getFirstName());
        $this->assertEquals('Finch', $brother->getLastName());
        $this->assertEquals('Junior', $brother->getMiddleName());
        $this->assertEquals($congregation, $brother->getCongregation());
        $this->assertTrue($brother->isMale());
        $this->assertEquals(new DateTime('1976-04-23'), $brother->getBirthDate());
        $this->assertEquals(new DateTime('1988-06-12'), $brother->getBaptismDate());
        $this->assertEquals($this->brotherRepository->findAll()->first(), $brother);
    }
}
