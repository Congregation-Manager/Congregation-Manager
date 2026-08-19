<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\User\Domain\UIUser;
use CongregationManager\Contract\Resource\AggregateRootId;

class AppUser extends UIUser implements AppUserInterface
{
    public function __construct(
        AggregateRootId $id,
        protected BrotherInterface $brother,
        string $email,
        ?string $password = null,
        ?string $localeCode = null
    ) {
        parent::__construct($id, $email, $password, $localeCode);
    }

    #[\Override]
    public function getBrother(): BrotherInterface
    {
        return $this->brother;
    }
}
