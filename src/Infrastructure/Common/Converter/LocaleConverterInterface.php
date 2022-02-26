<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Converter;

use InvalidArgumentException;

interface LocaleConverterInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function convertNameToCode(string $name, ?string $locale = null): string;

    /**
     * @throws InvalidArgumentException
     */
    public function convertCodeToName(string $code, ?string $locale = null): string;
}
