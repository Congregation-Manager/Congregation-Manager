<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Repository;

use CongregationManager\Bundle\Core\Entity\AppUIUserInterface;
use CongregationManager\Bundle\Core\Entity\AppUser;
use CongregationManager\Component\Core\Domain\Repository\AppUserRepositoryInterface;
use CongregationManager\Component\User\Domain\UserInterface;
use CongregationManager\Contract\Resource\AggregateRootId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<AppUIUserInterface>
 * @implements AppUserRepositoryInterface<AppUIUserInterface>
 *
 * @method AppUIUserInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppUIUserInterface|null findOneBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null)
 * @psalm-method list<AppUIUserInterface> findAll()
 *
 * @method AppUIUserInterface[] findAll()
 * @psalm-method list<AppUIUserInterface> findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
 *
 * @method AppUIUserInterface[] findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
 */
class AppUserRepository extends ServiceEntityRepository implements AppUserRepositoryInterface, PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppUser::class);
    }

    #[\Override]
    public function add(UserInterface $user): void
    {
        if (!$user instanceof AppUIUserInterface) {
            throw new \InvalidArgumentException(sprintf('Instances of "%s" are not supported.', $user::class));
        }
        $this->_em->persist($user);
    }

    public function findOneById(AggregateRootId $id): ?AppUIUserInterface
    {
        return $this->find($id);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    #[\Override]
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof AppUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
