<?php

namespace App\Infrastructure\User\Repository;

use App\Domain\User\Exception\Factory\UserInstanceNotValidFactory;
use App\Domain\User\Model\UserInterface;
use App\Domain\User\Repository\ResetPasswordRequestRepositoryInterface;
use App\Infrastructure\User\Model\ResetPasswordRequest;
use App\Infrastructure\User\Model\ResetPasswordRequestInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyCasts\Bundle\ResetPassword\Persistence\Repository\ResetPasswordRequestRepositoryTrait;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface as SymfonyResetPasswordRequestRepositoryInterface;

/**
 * @extends ServiceEntityRepository<ResetPasswordRequestInterface>
 *
 * @method ResetPasswordRequestInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResetPasswordRequestInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<ResetPasswordRequestInterface> findAll()
 * @method ResetPasswordRequestInterface[]    findAll()
 * @psalm-method list<ResetPasswordRequestInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ResetPasswordRequestInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResetPasswordRequestRepository extends ServiceEntityRepository implements ResetPasswordRequestRepositoryInterface, SymfonyResetPasswordRequestRepositoryInterface
{
    use ResetPasswordRequestRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordRequest::class);
    }

    public function createResetPasswordRequest(object $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken): ResetPasswordRequestInterface
    {
        if (!$user instanceof UserInterface) {
            throw UserInstanceNotValidFactory::createWithInstanceClass(get_class($user));
        }
        return new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
    }
}
