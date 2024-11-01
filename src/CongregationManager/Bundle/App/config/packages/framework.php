<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $frameworkConfig): void {
    $frameworkConfig
        ->assets()
        ->package('app', [
            'json_manifest_path' => '%kernel.project_dir%/public/app/build/manifest.json',
        ])
    ;
};
