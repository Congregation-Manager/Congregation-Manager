<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\FixturesBundle\DataFixtures;

use CongregationManager\Component\Congregation\Domain\Factory\BrotherFactoryInterface;
use CongregationManager\Component\Core\Domain\BrotherInterface as CoreBrotherInterface;
use CongregationManager\Component\Core\Domain\Congregation;
use CongregationManager\Component\Core\Domain\Factory\AppUserFactoryInterface;
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
        private readonly BrotherFactoryInterface $brotherFactory,
        private readonly AppUserFactoryInterface $appUserFactory,
    ) {
    }

    #[\Override]
    public function getDependencies(): array
    {
        return [CongregationFixtures::class];
    }

    #[\Override]
    public static function getGroups(): array
    {
        return ['congregation_manager_sample_data', 'congregation_manager_sample_congregation_data'];
    }

    #[\Override]
    public function load(ObjectManager $manager): void
    {
        foreach ($this->brotherFixtureData as $brotherData) {
            $congregation = $this->getReference(
                'congregation-' . $brotherData['congregation_name'],
                Congregation::class,
            );
            $brother = $this->brotherFactory->createNew(
                $brotherData['first_name'],
                $brotherData['last_name'],
                $congregation,
                $brotherData['is_male'],
                $brotherData['middle_name'],
                $brotherData['birth_date'] !== null ? new \DateTimeImmutable($brotherData['birth_date']) : null,
                $brotherData['baptism_date'] !== null ? new \DateTimeImmutable($brotherData['baptism_date']) : null,
            );
            Assert::isInstanceOf($brother, CoreBrotherInterface::class);
            if (array_key_exists('user', $brotherData)) {
                $user = $this->appUserFactory->createNew(
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
