<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\FixturesBundle\DataFixtures;

use CongregationManager\Component\Congregation\Domain\Congregation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

final class CongregationFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly array $congregationFixtureData,
    ) {
    }

    public static function getGroups(): array
    {
        return ['congregation_manager_sample_data', 'congregation_manager_sample_congregation_data'];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->congregationFixtureData as $congregationData) {
            $congregation = new Congregation($congregationData['name']);

            $manager->persist($congregation);

            $this->addReference('congregation-' . $congregation->getName(), $congregation);
        }
        $manager->flush();
    }
}
