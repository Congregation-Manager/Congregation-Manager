<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CongregationManager\Component\Congregation\Domain\Repository\BrotherRepositoryInterface;
use CongregationManager\Component\Core\Domain\BrotherInterface;
use InvalidArgumentException;

final readonly class BrotherContext implements Context
{
    public function __construct(
        private BrotherRepositoryInterface $brotherRepository
    ) {
    }

    /**
     * @Transform :brother
     */
    public function getBrotherByFirstNameAndLastName(string $fullName): BrotherInterface
    {
        [$firstName, $lastName] = explode(' ', $fullName);
        $brother = $this->brotherRepository->findOneBy([
            'firstName' => $firstName,
            'lastName' => $lastName,
        ]);

        if (!$brother instanceof BrotherInterface) {
            throw new InvalidArgumentException(sprintf(
                'Brother with first name "%s" and last name "%s" does not exist.',
                $firstName,
                $lastName
            ));
        }

        return $brother;
    }
}
