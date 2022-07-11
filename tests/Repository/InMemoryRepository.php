<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ObjectRepository as DoctrineObjectRepository;

/**
 * @template TKey of array-key
 * @template T of object
 * @implements DoctrineObjectRepository<T>
 * @template-implements DoctrineObjectRepository<T>
 */
abstract class InMemoryRepository implements DoctrineObjectRepository
{
    /**
     * @var ArrayCollection<TKey,T>
     */
    public ArrayCollection $objectCollection;

    /**
     * @param ArrayCollection<TKey,T>|null $objectCollection
     */
    public function __construct(ArrayCollection $objectCollection = null)
    {
        if ($objectCollection === null) {
            /** @var ArrayCollection<TKey,T> $objectCollection */
            $objectCollection = new ArrayCollection();
        }
        $this->objectCollection = $objectCollection;
    }

    /**
     * @param mixed $id
     *
     * @return T|null
     */
    public function find($id)
    {
        return $this->findOneBy([
            $this->getIdProperty() => $id,
        ]);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     *
     * @return ArrayCollection<TKey,T>
     */
    public function findAll(): ArrayCollection
    {
        return $this->findBy([]);
    }

    /**
     * @param array<string, mixed> $criteria
     * @param string[]|null        $orderBy
     * @param int|null             $limit
     * @param int|null             $offset
     *
     * @psalm-suppress ImplementedReturnTypeMismatch
     *
     * @return ArrayCollection<TKey,T>
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): ArrayCollection
    {
        $criteriaObject = Criteria::create();
        /* @psalm-suppress MixedAssignment */
        foreach ($criteria as $field => $value) {
            $criteriaObject->andWhere(Criteria::expr()->eq($field, $value));
        }
        if ($orderBy !== null) {
            $criteriaObject->orderBy($orderBy);
        }
        $criteriaObject->setMaxResults($limit);
        $criteriaObject->setFirstResult($offset);

        /** @var ArrayCollection<TKey,T> $matching */
        return $this->objectCollection->matching($criteriaObject);
    }

    /**
     * @param array<string, mixed> $criteria
     *
     * @return T|null
     */
    public function findOneBy(array $criteria)
    {
        /** @var T|false $first */
        $first = $this->findBy($criteria)
            ->first()
        ;

        return $first ?: null;
    }

    abstract public function getClassName(): string;

    abstract protected function getIdProperty(): string;
}
