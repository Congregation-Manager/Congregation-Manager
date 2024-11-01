<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Services;

use Symfony\Component\Mailer\Exception\UnsupportedSchemeException;
use Symfony\Component\Mailer\Transport\AbstractTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\TransportInterface;

final class BehatMailerFactory extends AbstractTransportFactory
{
    public function __construct(
        private TransportInterface $fakeMailerTransport
    ) {
    }

    public function create(Dsn $dsn): TransportInterface
    {
        if (!\in_array($dsn->getScheme(), $this->getSupportedSchemes(), true)) {
            throw new UnsupportedSchemeException($dsn, 'behat', $this->getSupportedSchemes());
        }

        return $this->fakeMailerTransport;
    }

    /**
     * @return array<int, string>
     */
    protected function getSupportedSchemes(): array
    {
        return ['behat'];
    }
}
