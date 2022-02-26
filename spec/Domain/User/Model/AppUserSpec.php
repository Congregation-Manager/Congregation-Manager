<?php

namespace spec\CongregationManager\Domain\User\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;
use CongregationManager\Domain\User\Model\AppUser;
use CongregationManager\Domain\User\Model\AppUserInterface;
use CongregationManager\Domain\User\Model\User;
use CongregationManager\Domain\User\Model\UserInterface;
use PhpSpec\ObjectBehavior;

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

    public function it_implements_app_user_interface(): void
    {
        $this->shouldBeAnInstanceOf(AppUserInterface::class);
    }

    public function it_should_extends_aggregate_root(): void
    {
        $this->shouldBeAnInstanceOf(AggregateRoot::class);
    }

    public function it_should_extends_user(): void
    {
        $this->shouldBeAnInstanceOf(User::class);
    }

    public function it_returns_email(): void
    {
        $this->getEmail()->shouldReturn('user@email.com');
    }
}
