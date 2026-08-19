<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain;

use CongregationManager\Contract\Resource\AggregateRootId;

class UIUser extends User implements UIUserInterface
{
    public function __construct(
        AggregateRootId $id,
        string $email,
        protected ?string $password = null,
        ?string $localeCode = null,
    ) {
        parent::__construct($id, $email, $localeCode);
    }

    #[\Override]
    public function getPassword(): ?string
    {
        return $this->password;
    }

    #[\Override]
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
}
