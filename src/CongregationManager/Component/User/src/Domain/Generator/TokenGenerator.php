<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain\Generator;

final class TokenGenerator implements TokenGeneratorInterface
{
    #[\Override]
    public function generate(): string
    {
        $string = '';

        while (($len = strlen($string)) < 20) {
            /** @var int<1, max> $size */
            $size = 20 - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}
