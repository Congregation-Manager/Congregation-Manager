<?php

namespace spec\App\Domain\User\Model;

use App\Domain\Common\Model\AggregateRoot;
use App\Domain\User\Model\AppUser;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\User\UserInterface;

class AppUserSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('user@email.com');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(AppUser::class);
    }

    public function it_implements_user_interface(): void
    {
        $this->shouldBeAnInstanceOf(UserInterface::class);
    }

    public function it_should_extends_aggregate_root(): void
    {
        $this->shouldBeAnInstanceOf(AggregateRoot::class);
    }

    public function it_returns_email(): void
    {
        $this->getEmail()->shouldReturn('user@email.com');
    }

    public function it_has_role_user_if_not_specified(): void
    {
        $this->getRoles()->shouldReturn(['ROLE_USER']);
    }
}
