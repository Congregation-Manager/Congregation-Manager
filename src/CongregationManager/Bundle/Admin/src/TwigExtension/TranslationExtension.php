<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin\TwigExtension;

use CongregationManager\Bundle\Admin\TwigRuntime\TranslationRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class TranslationExtension extends AbstractExtension
{
    #[\Override]
    public function getFilters(): array
    {
        return [new TwigFilter('trans_admin', [TranslationRuntime::class, 'trans'])];
    }
}
