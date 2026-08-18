<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Services\SharedStorageInterface;
use CongregationManager\Component\Core\Domain\Congregation;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CongregationContext implements Context
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
        $congregation = new Congregation($name);
        $this->entityManager->persist($congregation);
        $this->entityManager->flush();
        $this->sharedStorage->set('congregation', $congregation);
    }
}
