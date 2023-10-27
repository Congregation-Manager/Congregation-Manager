<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Services\SharedStorageInterface;
use CongregationManager\Bundle\Resource\UuidV4;
use CongregationManager\Component\Congregation\Domain\Congregation;
use Doctrine\ORM\EntityManagerInterface;

final class CongregationContext implements Context
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SharedStorageInterface $sharedStorage
    ) {
    }

    /**
     * @Given there is a congregation :name
     */
    public function thereIsACongregation(string $name): void
    {
        $congregation = new Congregation(new UuidV4(), $name);
        $this->entityManager->persist($congregation);
        $this->entityManager->flush();
        $this->sharedStorage->set('congregation', $congregation);
    }
}
