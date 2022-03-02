<?php

namespace CongregationManager\Infrastructure\User\Repository;

use CongregationManager\Domain\User\Repository\AdminUserRepositoryInterface;
use CongregationManager\Infrastructure\User\Model\AdminUser;
use CongregationManager\Infrastructure\User\Model\AdminUserInterface;
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
 * @method AdminUserInterface[]    findAll()
 * @psalm-method list<AdminUserInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method AdminUserInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminUserRepository extends ServiceEntityRepository implements AdminUserRepositoryInterface, PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminUser::class);
    }

    public function add(\CongregationManager\Domain\User\Model\AdminUserInterface $adminUser): void
    {
        $this->_em->persist($adminUser);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof AdminUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
