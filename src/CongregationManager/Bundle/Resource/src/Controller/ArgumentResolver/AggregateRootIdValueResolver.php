<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\Controller\ArgumentResolver;

use CongregationManager\Bundle\Resource\Uid\UuidAggregateRootId;
use CongregationManager\Contract\Resource\AggregateRootId;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Turns a route placeholder into an identifier, so controllers can ask for an
 * AggregateRootId without knowing which implementation backs it.
 */
final class AggregateRootIdValueResolver implements ValueResolverInterface
{
    /**
     * @return iterable<AggregateRootId>
     */
    #[\Override]
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== AggregateRootId::class) {
            return [];
        }

        $value = $request->attributes->get($argument->getName());
        if (!is_string($value)) {
            return [];
        }

        try {
            yield UuidAggregateRootId::convertToPHPValue($value);
        } catch (InvalidArgumentException $invalidArgumentException) {
            throw new NotFoundHttpException(
                sprintf('"%s" is not a valid identifier.', $value),
                $invalidArgumentException
            );
        }
    }
}
