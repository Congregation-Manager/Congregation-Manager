<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Services;

use CongregationManager\Behat\Services\Setter\CookieSetterInterface;
use CongregationManager\Bundle\User\Entity\UIUserInterface;
use Symfony\Component\HttpFoundation\Session\SessionFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

final readonly class SecurityService
{
    private SessionInterface $session;

    private string $sessionTokenVariable;

    public function __construct(
        private SessionFactoryInterface $sessionFactory,
        private CookieSetterInterface $cookieSetter,
        private string $firewallContextName,
    ) {
        $this->session = $this->sessionFactory->createSession();
        $this->sessionTokenVariable = sprintf('_security_%s', $firewallContextName);
    }

    public function logIn(UIUserInterface $user): void
    {
        $token = new UsernamePasswordToken($user, $this->firewallContextName, $user->getRoles());

        $this->setToken($token);
    }

    private function setToken(TokenInterface $token): void
    {
        $serializedToken = serialize($token);
        $this->session->set($this->sessionTokenVariable, $serializedToken);
        $this->session->save();
        $this->cookieSetter->setCookie($this->session->getName(), $this->session->getId());
    }
}
