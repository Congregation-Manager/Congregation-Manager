<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Application\Congregation;

use CongregationManager\Component\Congregation\Application\CreateCongregation;
use CongregationManager\Component\Congregation\Domain\Repository\CongregationRepositoryInterface;
use CongregationManager\Component\Congregation\Infrastructure\Repository\InMemory\CongregationRepository;
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
        $congregations = $this->congregationRepository->findAll();
        $this->assertSame(reset($congregations), $congregation);
    }
}
