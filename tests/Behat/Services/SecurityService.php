<?php

namespace CongregationManager\Tests\Behat\Services;

use CongregationManager\Tests\Behat\Services\Setter\CookieSetterInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

final class SecurityService implements SecurityServiceInterface
{
    private string $sessionTokenVariable;

    public function __construct(
        private RequestStack $requestStack,
        private string $firewallContextName,
        private CookieSetterInterface $cookieSetter
    ) {
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
        $session = $this->requestStack->getSession();
        $session->set($this->sessionTokenVariable, $serializedToken);
        $session->save();
        $this->cookieSetter->setCookie($session->getName(), $session->getId());
    }
}
