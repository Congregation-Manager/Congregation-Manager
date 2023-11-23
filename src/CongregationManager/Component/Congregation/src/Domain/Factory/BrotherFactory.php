<?php

declare(strict_types=1);

namespace CongregationManager\Component\Congregation\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\CongregationManager\Contract\Resource\src\IdGeneratorInterface;
use Webmozart\Assert\Assert;

final class BrotherFactory implements BrotherFactoryInterface
{
    /**
     * @param class-string $fqcn
     */
    public function __construct(
        private string $fqcn,
        private IdGeneratorInterface $idGenerator,
    ) {
    }

    /**
     * @psalm-suppress MixedMethodCall
     */
    public function createNew(string $name): BrotherInterface
    {
        $brother = new $this->fqcn($this->idGenerator->generateNew(), $name);
        Assert::isInstanceOf($brother, BrotherInterface::class);

        return $brother;
    }
}
