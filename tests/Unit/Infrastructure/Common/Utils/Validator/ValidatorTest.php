<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Infrastructure\Common\Utils\Validator;

use CongregationManager\Infrastructure\Common\Utils\Validator\Validator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function test_that_it_does_not_validate_empty_string(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validateString('');
    }

    public function test_that_it_does_not_validate_null_as_string(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validateString(null);
    }

    public function test_that_it_validates_valid_string(): void
    {
        $this->assertEquals(
            'string',
            $this->validator->validateString('string')
        );
    }

    public function test_that_it_does_not_validate_empty_password(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validatePassword('');
    }

    public function test_that_it_does_not_validate_short_password(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validatePassword('asdasds');
    }

    public function test_that_it_validates_strong_password(): void
    {
        $this->assertEquals(
            'p455w0rd',
            $this->validator->validatePassword('p455w0rd')
        );
    }

    public function test_that_it_does_not_validate_empty_email(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validateEmail('');
    }

    public function test_that_it_does_not_validate_mail_without_at(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validateEmail('asdasds');
    }

    public function test_that_it_validates_valid_email(): void
    {
        $this->assertEquals(
            'test@mail.com',
            $this->validator->validateEmail('test@mail.com')
        );
    }
}
