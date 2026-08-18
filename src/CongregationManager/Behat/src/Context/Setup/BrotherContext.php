<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Services\SharedStorageInterface;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Core\Domain\Brother;
use Doctrine\ORM\EntityManagerInterface;
use Webmozart\Assert\Assert;

final readonly class BrotherContext implements Context
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SharedStorageInterface $sharedStorage
    ) {
    }

    /**
     * @Given /^there is a (brother|sister) "([^"]*)"$/
     */
    public function thereIsABrother(string $type, string $fullName): void
    {
        /** @var ?CongregationInterface $congregation */
        $congregation = $this->sharedStorage->get('congregation');
        Assert::isInstanceOf($congregation, CongregationInterface::class);
        [$firstName, $lastName] = explode(' ', $fullName);
        $brother = new Brother($firstName, $lastName, $congregation);
        if ($type === 'sister') {
            $brother->setMale(false);
        }
        $this->entityManager->persist($brother);
        $this->entityManager->flush();
        $this->sharedStorage->set('brother', $brother);
    }
}
