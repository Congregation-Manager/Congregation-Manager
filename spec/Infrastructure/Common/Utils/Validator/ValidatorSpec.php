<?php

namespace spec\CongregationManager\Infrastructure\Common\Utils\Validator;

use CongregationManager\Infrastructure\Common\Utils\Validator\Validator;
use PhpSpec\ObjectBehavior;

class ValidatorSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Validator::class);
    }

    public function it_validates_successfully_correct_password(): void
    {
        $this->validatePassword('password')->shouldReturn('password');
    }

    public function it_throws_if_password_is_null(): void
    {
        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('validatePassword', [null]);
    }

    public function it_throws_if_password_is_empty(): void
    {
        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('validatePassword', ['']);
    }

    public function it_throws_if_password_trimmed_length_is_less_than_six_characters(): void
    {
        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('validatePassword', [' passw ']);
    }

    public function it_validates_successfully_correct_email(): void
    {
        $this->validateEmail('user@email.com')->shouldReturn('user@email.com');
    }

    public function it_throws_if_email_is_null(): void
    {
        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('validateEmail', [null]);
    }

    public function it_throws_if_email_is_empty(): void
    {
        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('validateEmail', ['']);
    }

    public function it_throws_if_email_does_not_contain_at_character(): void
    {
        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('validateEmail', ['infoemail.com']);
    }
}
