<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Repository;

use CongregationManager\Bundle\Core\Entity\AdminUIUserInterface;
use CongregationManager\Bundle\Core\Entity\AdminUser;
use CongregationManager\Bundle\Resource\Repository\ResourceRepository;
use CongregationManager\Component\Core\Domain\AdminUserInterface as DomainAdminUserInterface;
use CongregationManager\Component\Core\Domain\Repository\AdminUserRepositoryInterface;
use CongregationManager\Component\User\Domain\UserInterface;
use CongregationManager\Contract\Resource\AggregateRootId;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ResourceRepository<AdminUIUserInterface>
 * @implements AdminUserRepositoryInterface<AdminUIUserInterface>
 */
class AdminUserRepository extends ResourceRepository implements AdminUserRepositoryInterface, PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminUser::class);
    }

    #[\Override]
    public function add(UserInterface $user): void
    {
        if (!$user instanceof AdminUIUserInterface) {
            throw new \InvalidArgumentException(sprintf('Instances of "%s" are not supported.', $user::class));
        }
        $this->_em->persist($user);
    }

    public function findOneById(AggregateRootId $id): ?DomainAdminUserInterface
    {
        return $this->find($id);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    #[\Override]
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof AdminUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
