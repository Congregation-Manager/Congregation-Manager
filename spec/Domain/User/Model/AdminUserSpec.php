<?php

namespace spec\App\Domain\User\Model;

use App\Domain\Common\Model\AggregateRoot;
use App\Domain\User\Model\AdminUser;
use App\Domain\User\Model\AdminUserInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Model\UserInterface;
use PhpSpec\ObjectBehavior;

class AdminUserSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('admin@email.com');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(AdminUser::class);
    }

    public function it_implements_user_interface(): void
    {
        $this->shouldBeAnInstanceOf(UserInterface::class);
    }

    public function it_implements_admin_user_interface(): void
    {
        $this->shouldBeAnInstanceOf(AdminUserInterface::class);
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
        $this->getEmail()->shouldReturn('admin@email.com');
    }
}
