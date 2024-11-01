<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Repository;

use CongregationManager\Bundle\User\Entity\ResetPasswordRequest;
use CongregationManager\Bundle\User\Entity\ResetPasswordRequestInterface;
use CongregationManager\Component\User\Domain\AdminUser;
use CongregationManager\Component\User\Domain\AppUser;
use CongregationManager\Component\User\Domain\Exception\Factory\UserInstanceNotValidFactory;
use CongregationManager\Component\User\Domain\Repository\ResetPasswordRequestRepositoryInterface;
use CongregationManager\Component\User\Domain\UserInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface as SymfonyResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Persistence\Repository\ResetPasswordRequestRepositoryTrait;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface as SymfonyResetPasswordRequestRepositoryInterface;

/**
 * @extends ServiceEntityRepository<ResetPasswordRequestInterface>
 *
 * @method ResetPasswordRequestInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResetPasswordRequestInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<ResetPasswordRequestInterface> findAll()
 *
 * @method ResetPasswordRequestInterface[] findAll()
 * @psalm-method list<ResetPasswordRequestInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method ResetPasswordRequestInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResetPasswordRequestRepository extends ServiceEntityRepository implements ResetPasswordRequestRepositoryInterface, SymfonyResetPasswordRequestRepositoryInterface
{
    use ResetPasswordRequestRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordRequest::class);
    }

    #[\Override]
    public function createResetPasswordRequest(
        object $user,
        \DateTimeInterface $expiresAt,
        string $selector,
        string $hashedToken
    ): ResetPasswordRequestInterface {
        if (!$user instanceof UserInterface) {
            throw UserInstanceNotValidFactory::createWithInstanceClass($user::class);
        }

        return new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
    }

    #[\Override]
    public function getMostRecentNonExpiredRequestDate(object $user): ?\DateTimeInterface
    {
        // Normally there is only 1 max request per use, but written to be flexible
        $queryBuilder = $this->createQueryBuilder('t');
        if ($user instanceof AdminUser) {
            $queryBuilder->where('t.adminUser = :user');
        } elseif ($user instanceof AppUser) {
            $queryBuilder->where('t.appUser = :user');
        } else {
            throw UserInstanceNotValidFactory::createWithInstanceClass($user::class);
        }

        /** @var SymfonyResetPasswordRequestInterface|null $resetPasswordRequest */
        $resetPasswordRequest = $queryBuilder
            ->setParameter('user', $user)
            ->orderBy('t.requestedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneorNullResult()
        ;

        if ($resetPasswordRequest !== null && !$resetPasswordRequest->isExpired()) {
            return $resetPasswordRequest->getRequestedAt();
        }

        return null;
    }

    #[\Override]
    public function removeResetPasswordRequest(SymfonyResetPasswordRequestInterface $resetPasswordRequest): void
    {
        $queryBuilder = $this->createQueryBuilder('t');
        if ($resetPasswordRequest->getUser() instanceof AdminUser) {
            $queryBuilder->where('t.adminUser = :user');
        } elseif ($resetPasswordRequest->getUser() instanceof AppUser) {
            $queryBuilder->where('t.appUser = :user');
        } else {
            throw UserInstanceNotValidFactory::createWithInstanceClass($resetPasswordRequest->getUser()::class);
        }

        $queryBuilder
            ->delete()
            ->setParameter('user', $resetPasswordRequest->getUser())
            ->getQuery()
            ->execute()
        ;
    }
}
