<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Repository;

use CongregationManager\Bundle\Core\Entity\AdminResetPasswordRequest;
use CongregationManager\Bundle\Core\Entity\AdminUIUserInterface;
use CongregationManager\Bundle\Core\Entity\AppResetPasswordRequest;
use CongregationManager\Bundle\Core\Entity\AppUIUserInterface;
use CongregationManager\Bundle\Resource\Doctrine\DBAL\Types\UuidAggregateRootIdType;
use CongregationManager\Bundle\User\Entity\ResetPasswordRequestInterface;
use CongregationManager\Bundle\User\Exception\Factory\UserInstanceNotValidFactory;
use CongregationManager\Component\User\Domain\Repository\ResetPasswordRequestRepositoryInterface;
use CongregationManager\Contract\Resource\AggregateRootId;
use CongregationManager\Contract\Resource\IdGeneratorInterface;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Clock\Clock;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface as SymfonyResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface as SymfonyResetPasswordRequestRepositoryInterface;

/**
 * Admin and app users keep their reset requests in their own table, so the repository
 * picks the class from the user it is given instead of being bound to a single entity.
 */
final readonly class ResetPasswordRequestRepository implements ResetPasswordRequestRepositoryInterface, SymfonyResetPasswordRequestRepositoryInterface
{
    /**
     * @var array<class-string<ResetPasswordRequestInterface>>
     */
    private const array REQUEST_CLASSES = [AdminResetPasswordRequest::class, AppResetPasswordRequest::class];

    public function __construct(
        private EntityManagerInterface $entityManager,
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createResetPasswordRequest(
        object $user,
        DateTimeInterface $expiresAt,
        string $selector,
        string $hashedToken
    ): SymfonyResetPasswordRequestInterface {
        if ($user instanceof AdminUIUserInterface) {
            return new AdminResetPasswordRequest(
                $this->idGenerator->generateNew(),
                $expiresAt,
                $hashedToken,
                $user,
                $selector
            );
        }
        if ($user instanceof AppUIUserInterface) {
            return new AppResetPasswordRequest(
                $this->idGenerator->generateNew(),
                $expiresAt,
                $hashedToken,
                $user,
                $selector
            );
        }

        throw UserInstanceNotValidFactory::createWithInstanceClass($user::class);
    }

    #[\Override]
    public function getUserIdentifier(object $user): string
    {
        return (string) $this->getUserId($user);
    }

    #[\Override]
    public function persistResetPasswordRequest(SymfonyResetPasswordRequestInterface $resetPasswordRequest): void
    {
        $this->entityManager->persist($resetPasswordRequest);
        $this->entityManager->flush();
    }

    #[\Override]
    public function findResetPasswordRequest(string $selector): ?SymfonyResetPasswordRequestInterface
    {
        // The selector alone does not tell which kind of user asked for the reset.
        foreach (self::REQUEST_CLASSES as $requestClass) {
            $resetPasswordRequest = $this->entityManager->getRepository($requestClass)
->findOneBy([
    'selector' => $selector,
]);
            if ($resetPasswordRequest instanceof SymfonyResetPasswordRequestInterface) {
                return $resetPasswordRequest;
            }
        }

        return null;
    }

    #[\Override]
    public function getMostRecentNonExpiredRequestDate(object $user): ?DateTimeInterface
    {
        /** @var SymfonyResetPasswordRequestInterface|null $resetPasswordRequest */
        $resetPasswordRequest = $this->entityManager->createQueryBuilder()
            ->select('t')
            ->from($this->getRequestClassForUser($user), 't')
            ->where('t.user = :user')
            ->setParameter('user', $this->getUserId($user), UuidAggregateRootIdType::NAME)
            ->orderBy('t.requestedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if ($resetPasswordRequest instanceof SymfonyResetPasswordRequestInterface
            && !$resetPasswordRequest->isExpired()
        ) {
            return $resetPasswordRequest->getRequestedAt();
        }

        return null;
    }

    #[\Override]
    public function removeResetPasswordRequest(SymfonyResetPasswordRequestInterface $resetPasswordRequest): void
    {
        $this->removeRequests($resetPasswordRequest->getUser());
    }

    #[\Override]
    public function removeExpiredResetPasswordRequests(): int
    {
        $time = Clock::get()->now()->modify('-1 week');
        $removed = 0;
        foreach (self::REQUEST_CLASSES as $requestClass) {
            /** @var int $deleted */
            $deleted = $this->entityManager->createQueryBuilder()
                ->delete($requestClass, 't')
                ->where('t.expiresAt <= :time')
                ->setParameter('time', $time, Types::DATETIME_IMMUTABLE)
                ->getQuery()
                ->execute()
            ;
            $removed += $deleted;
        }

        return $removed;
    }

    public function removeRequests(object $user): void
    {
        $this->entityManager->createQueryBuilder()
            ->delete($this->getRequestClassForUser($user), 't')
            ->where('t.user = :user')
            ->setParameter('user', $this->getUserId($user), UuidAggregateRootIdType::NAME)
            ->getQuery()
            ->execute()
        ;
    }

    private function getUserId(object $user): AggregateRootId
    {
        $identifier = $this->entityManager
            ->getUnitOfWork()
            ->getSingleIdentifierValue($user)
        ;
        if (!$identifier instanceof AggregateRootId) {
            throw new RuntimeException(sprintf(
                'Unable to read the identifier of "%s": expected an identifier, got "%s".',
                $user::class,
                get_debug_type($identifier)
            ));
        }

        return $identifier;
    }

    /**
     * @return class-string<ResetPasswordRequestInterface>
     */
    private function getRequestClassForUser(object $user): string
    {
        if ($user instanceof AdminUIUserInterface) {
            return AdminResetPasswordRequest::class;
        }
        if ($user instanceof AppUIUserInterface) {
            return AppResetPasswordRequest::class;
        }

        throw UserInstanceNotValidFactory::createWithInstanceClass($user::class);
    }
}
