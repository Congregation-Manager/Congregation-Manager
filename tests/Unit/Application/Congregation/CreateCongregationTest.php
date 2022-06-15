<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Application\Congregation;

use CongregationManager\Application\Congregation\CreateCongregation;
use CongregationManager\Domain\Congregation\Repository\CongregationRepositoryInterface;
use CongregationManager\Tests\Repository\CongregationRepository;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateCongregationTest extends TestCase
{
    private CongregationRepositoryInterface $congregationRepository;

    private CreateCongregation $createCongregation;

    protected function setUp(): void
    {
        $this->congregationRepository = new CongregationRepository();
        $this->createCongregation = new CreateCongregation($this->congregationRepository);
    }

    public function testThatItCreatesANewCongregation(): void
    {
        $congregation = $this->createCongregation->create('Carrollton');

        $this->assertSame('Carrollton', $congregation->getName());
        $this->assertSame($this->congregationRepository->findAll()->first(), $congregation);
    }
}
