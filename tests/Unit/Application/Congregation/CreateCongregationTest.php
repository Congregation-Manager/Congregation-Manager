<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Application\Congregation;

use CongregationManager\Application\Congregation\CreateCongregation;
use CongregationManager\Domain\Congregation\Repository\CongregationRepositoryInterface;
use CongregationManager\Tests\Repository\CongregationRepository;
use PHPUnit\Framework\TestCase;

class CreateCongregationTest extends TestCase
{
    private CongregationRepositoryInterface $congregationRepository;

    protected function setUp(): void
    {
        $this->congregationRepository = new CongregationRepository();
        $this->action = new CreateCongregation($this->congregationRepository);
    }

    public function test_that_it_creates_a_new_congregation(): void
    {
        $congregation = $this->action->create('Carrollton');

        $this->assertEquals('Carrollton', $congregation->getName());
        $this->assertEquals($this->congregationRepository->findAll()->first(), $congregation);
    }
}
