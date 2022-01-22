<?php

namespace App\Infrastructure\User\Repository;

use App\Domain\User\Model\AppUserInterface;
use App\Domain\User\Repository\AppUserRepositoryInterface;
use App\Infrastructure\User\Model\AppUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<AppUserInterface>
 *
 * @method AppUserInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppUserInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<AppUserInterface> findAll()
 * @method AppUserInterface[]    findAll()
 * @psalm-method list<AppUserInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method AppUserInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppUserRepository extends ServiceEntityRepository implements AppUserRepositoryInterface, PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppUser::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof AppUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
