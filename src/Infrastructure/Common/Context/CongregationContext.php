<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Context;

use CongregationManager\Domain\Common\Context\CongregationContextInterface;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\User\Model\AppUserInterface;
use RuntimeException;
use Symfony\Component\Security\Core\Security;

final class CongregationContext implements CongregationContextInterface
{
    public function __construct(
        private Security $security
    ) {
    }

    public function getCongregation(): CongregationInterface
    {
        $user = $this->security->getUser();
        if (!$user instanceof AppUserInterface) {
           throw new RuntimeException('Unable to retrieve the app user to determine the Congregation.');
        }

        return $user->getBrother()->getCongregation();
    }
}
