<?php

declare(strict_types=1);

use Symfony\Config\TwigConfig;

return static function (TwigConfig $twigConfig): void {
    $twigConfig
        ->formThemes(['bootstrap_5_layout.html.twig'])
    ;
};
