<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Repository;

use CongregationManager\Bundle\User\Entity\AdminUser;
use CongregationManager\Bundle\User\Entity\AdminUserInterface;
use CongregationManager\Component\User\Domain\AdminUserInterface as DomainAdminUserInterface;
use CongregationManager\Component\User\Domain\Repository\AdminUserRepositoryInterface;
use CongregationManager\Contract\Resource\Id;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<AdminUserInterface>
 *
 * @method AdminUserInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminUserInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<AdminUserInterface> findAll()
 *
 * @method AdminUserInterface[] findAll()
 * @psalm-method list<AdminUserInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method AdminUserInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminUserRepository extends ServiceEntityRepository implements AdminUserRepositoryInterface, PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminUser::class);
    }

    public function add(DomainAdminUserInterface $adminUser): void
    {
        $this->_em->persist($adminUser);
    }

    public function findOneById(Id $id): ?DomainAdminUserInterface
    {
        return $this->find($id);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (! $user instanceof AdminUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
