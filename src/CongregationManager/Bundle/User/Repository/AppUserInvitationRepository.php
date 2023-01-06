<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Repository;

use CongregationManager\Component\User\Domain\AppUserInvitation as DomainAppUserInvitation;
use CongregationManager\Component\User\Domain\Repository\AppUserInvitationRepositoryInterface;
use CongregationManager\Infrastructure\User\Model\AppUserInvitation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppUserInvitation>
 *
 * @method AppUserInvitation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppUserInvitation|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<AppUserInvitation> findAll()
 *
 * @method AppUserInvitation[] findAll()
 * @psalm-method list<AppUserInvitation> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method AppUserInvitation[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppUserInvitationRepository extends ServiceEntityRepository implements AppUserInvitationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppUserInvitation::class);
    }

    public function add(DomainAppUserInvitation $appUserInvitation): void
    {
        $this->_em->persist($appUserInvitation);
    }

    public function findByToken(string $token): ?DomainAppUserInvitation
    {
        return $this->findOneBy([
            'token' => $token,
        ]);
    }

    public function remove(DomainAppUserInvitation $appUserInvitation): void
    {
        $this->_em->remove($appUserInvitation);
    }
}
