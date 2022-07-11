<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Domain\Congregation\Model\Brother;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Tests\Behat\Services\SharedStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Webmozart\Assert\Assert;

final class BrotherContext implements Context
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
