<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Repository;

use CongregationManager\Component\Core\Domain\AppUserInvitation;
use CongregationManager\Component\Core\Domain\AppUserInvitation as DomainAppUserInvitation;
use CongregationManager\Component\Core\Domain\Repository\AppUserInvitationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppUserInvitation>
 *
 * @method AppUserInvitation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppUserInvitation|null findOneBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null)
 * @psalm-method list<AppUserInvitation> findAll()
 *
 * @method AppUserInvitation[] findAll()
 * @psalm-method list<AppUserInvitation> findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
 *
 * @method AppUserInvitation[] findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
 */
class AppUserInvitationRepository extends ServiceEntityRepository implements AppUserInvitationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppUserInvitation::class);
    }

    #[\Override]
    public function add(DomainAppUserInvitation $appUserInvitation): void
    {
        $this->_em->persist($appUserInvitation);
    }

    #[\Override]
    public function findByToken(string $token): ?DomainAppUserInvitation
    {
        return $this->findOneBy([
            'token' => $token,
        ]);
    }

    #[\Override]
    public function remove(DomainAppUserInvitation $appUserInvitation): void
    {
        $this->_em->remove($appUserInvitation);
    }
}
