<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\FixturesBundle\DataFixtures;

use CongregationManager\Bundle\User\Entity\AdminUser;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

final class AdminFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly array $adminFixtureData,
        private readonly string $defaultLocale,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public static function getGroups(): array
    {
        return ['congregation_manager_sample_data', 'congregation_manager_sample_admin_data'];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->adminFixtureData as $adminData) {
            $admin = new AdminUser($adminData['email'], null, $adminData['locale'] ?? $this->defaultLocale);
            $admin->setRoles($adminData['super_admin'] ? [AdminUser::SUPER_ADMIN_ROLE] : [AdminUser::ADMIN_ROLE]);
            $encodedPassword = $this->userPasswordHasher->hashPasswordForUser($adminData['password'], $admin);
            $admin->setPassword($encodedPassword);

            $manager->persist($admin);

            $this->addReference('admin-' . $admin->getEmail(), $admin);
        }
        $manager->flush();
    }
}
