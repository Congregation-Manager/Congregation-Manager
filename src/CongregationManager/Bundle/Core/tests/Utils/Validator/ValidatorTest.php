<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Tests\Utils\Validator;

use CongregationManager\Bundle\Core\Utils\Validator\Validator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ValidatorTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testThatItDoesNotValidateEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validateString('');
    }

    public function testThatItDoesNotValidateNullAsString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validateString(null);
    }

    public function testThatItValidatesValidString(): void
    {
        $this->assertSame('string', $this->validator->validateString('string'));
    }

    public function testThatItDoesNotValidateEmptyPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validatePassword('');
    }

    public function testThatItDoesNotValidateShortPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validatePassword('asdasds');
    }

    public function testThatItValidatesStrongPassword(): void
    {
        $this->assertSame('p455w0rd', $this->validator->validatePassword('p455w0rd'));
    }

    public function testThatItDoesNotValidateEmptyEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validateEmail('');
    }

    public function testThatItDoesNotValidateMailWithoutAt(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validateEmail('asdasds');
    }

    public function testThatItValidatesValidEmail(): void
    {
        $this->assertSame('test@mail.com', $this->validator->validateEmail('test@mail.com'));
    }
}
