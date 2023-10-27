<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\CongregationManager\Contract\Resource\src\IdGeneratorInterface;
use Webmozart\Assert\Assert;

final readonly class CongregationFactory implements CongregationFactoryInterface
{
    /**
     * @param class-string $fqcn
     */
    public function __construct(
        private string $fqcn,
        private IdGeneratorInterface $idGenerator,
    ) {
    }

    public function createNew(string $name): CongregationInterface
    {
        $congregation = new $this->fqcn($this->idGenerator->generateNew(), $name);
        Assert::isInstanceOf($congregation, CongregationInterface::class);

        return $congregation;
    }
}
