<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Common\Converter;

interface LocaleConverterInterface
{
    public function convertNameToCode(string $name, ?string $locale = null): string;

    public function convertCodeToName(string $code, ?string $locale = null): string;
}
