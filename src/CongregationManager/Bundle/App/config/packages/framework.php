<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $frameworkConfig): void {
    $frameworkConfig
        ->assets()
        ->jsonManifestPath('%kernel.project_dir%/public/app/build/manifest.json')
    ;
};
