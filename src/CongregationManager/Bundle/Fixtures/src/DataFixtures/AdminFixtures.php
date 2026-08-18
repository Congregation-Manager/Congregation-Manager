<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\FixturesBundle\DataFixtures;

use CongregationManager\Bundle\Core\Entity\AdminUIUserInterface;
use CongregationManager\Bundle\Core\Entity\AdminUser;
use CongregationManager\Component\Core\Domain\Factory\AdminUserFactoryInterface;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Webmozart\Assert\Assert;

/**
 * @psalm-type AdminFixtureData = array{email: string, password: string, locale: ?string, super_admin: bool}
 */
final class AdminFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @param array<array-key, AdminFixtureData> $adminFixtureData
     */
    public function __construct(
        private readonly array $adminFixtureData,
        private readonly string $defaultLocale,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly AdminUserFactoryInterface $adminUserFactory,
    ) {
    }

    #[\Override]
    public static function getGroups(): array
    {
        return ['congregation_manager_sample_data', 'congregation_manager_sample_admin_data'];
    }

    #[\Override]
    public function load(ObjectManager $manager): void
    {
        foreach ($this->adminFixtureData as $adminData) {
            $admin = $this->adminUserFactory->createNew(
                $adminData['email'],
                null,
                $adminData['locale'] ?? $this->defaultLocale,
            );
            Assert::isInstanceOf($admin, AdminUIUserInterface::class);
            $admin->setRoles($adminData['super_admin'] ? [AdminUser::SUPER_ADMIN_ROLE] : [AdminUser::ADMIN_ROLE]);
            $encodedPassword = $this->userPasswordHasher->hashPasswordForUser($adminData['password'], $admin);
            $admin->setPassword($encodedPassword);

            $manager->persist($admin);

            $this->addReference('admin-' . $admin->getEmail(), $admin);
        }
        $manager->flush();
    }
}
