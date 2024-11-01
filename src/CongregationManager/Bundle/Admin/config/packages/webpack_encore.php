<?php

declare(strict_types=1);

use Symfony\Config\WebpackEncoreConfig;

return static function (WebpackEncoreConfig $webpackEncoreConfig): void {
    $webpackEncoreConfig
        ->outputPath('%kernel.project_dir%/public/admin/build')
        ->scriptAttributes('defer', true)
        ->builds('admin', '%kernel.project_dir%/public/admin/build')
    ;
};
