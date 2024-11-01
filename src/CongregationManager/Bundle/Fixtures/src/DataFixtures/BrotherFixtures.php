<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\FixturesBundle\DataFixtures;

use CongregationManager\Bundle\User\Entity\AppUser;
use CongregationManager\Component\Congregation\Domain\Brother;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Webmozart\Assert\Assert;

/**
 * @psalm-type BrotherFixtureData = array{first_name: string, last_name: string, congregation_name: string, middle_name: ?string, is_male: bool, birth_date: ?string, baptism_date: ?string, user?: array{email: string, password: string, locale: ?string}}
 */
final class BrotherFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    /**
     * @param array<array-key, BrotherFixtureData> $brotherFixtureData
     */
    public function __construct(
        private readonly array $brotherFixtureData,
        private readonly string $defaultLocale,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function getDependencies(): array
    {
        return [CongregationFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['congregation_manager_sample_data', 'congregation_manager_sample_congregation_data'];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->brotherFixtureData as $brotherData) {
            $congregation = $this->getReference('congregation-' . $brotherData['congregation_name']);
            Assert::isInstanceOf($congregation, CongregationInterface::class);

            $brother = new Brother(
                $brotherData['first_name'],
                $brotherData['last_name'],
                $congregation,
                $brotherData['is_male'],
                $brotherData['middle_name'],
                $brotherData['birth_date'] !== null ? new \DateTimeImmutable($brotherData['birth_date']) : null,
                $brotherData['baptism_date'] !== null ? new \DateTimeImmutable($brotherData['baptism_date']) : null,
            );
            if (array_key_exists('user', $brotherData)) {
                $user = new AppUser(
                    $brother,
                    $brotherData['user']['email'],
                    null,
                    $brotherData['user']['locale'] ?? $this->defaultLocale,
                );
                $encodedPassword = $this->userPasswordHasher->hashPasswordForUser(
                    $brotherData['user']['password'],
                    $user
                );
                $user->setPassword($encodedPassword);
                $brother->setUser($user);
                $manager->persist($user);
            }

            $manager->persist($brother);

            $this->addReference('brother-' . $brother->getFullName(), $brother);
        }
        $manager->flush();
    }
}
