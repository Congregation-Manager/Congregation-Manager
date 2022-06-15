<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Congregation\Repository\BrotherRepositoryInterface;
use InvalidArgumentException;

final class BrotherContext implements Context
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

        return $brother ?? throw new InvalidArgumentException(sprintf(
            'Brother with first name "%s" and last name "%s" does not exist.',
            $firstName,
            $lastName
        ));
    }
}
