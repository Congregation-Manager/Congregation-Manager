<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Services;

use CongregationManager\Bundle\User\Model\UserInterface;
use CongregationManager\Tests\Behat\Services\Setter\CookieSetterInterface;
use Symfony\Component\HttpFoundation\Session\SessionFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

final class SecurityService
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

    public function logIn(UserInterface $user): void
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
