<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\TwigExtension;

use CongregationManager\Bundle\App\TwigRuntime\TranslationRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class TranslationExtension extends AbstractExtension
{
    #[\Override]
    public function getFilters(): array
    {
        return [new TwigFilter('trans_app', [TranslationRuntime::class, 'trans'])];
    }
}
