<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class LocaleExtension extends AbstractExtension
{
    /** @return TwigFilter[] */
    public function getFilters(): array
    {
        return [
            new TwigFilter('locale_name', [LocaleRuntime::class, 'convertCodeToName']),
        ];
    }
}
