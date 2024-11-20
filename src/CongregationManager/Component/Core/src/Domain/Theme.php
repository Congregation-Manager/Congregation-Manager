<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

enum Theme: string
{
    case LIGHT = 'light';
    case DARK = 'dark';
}
