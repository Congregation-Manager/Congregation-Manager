<?php

declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJsonSection;

return static function (MBConfig $mbConfig): void {
    $mbConfig->packageDirectories([__DIR__ . '/src/CongregationManager']);

    // what extra parts to add after merge?
    $mbConfig->dataToAppend([
        ComposerJsonSection::REQUIRE_DEV => [
            'phpunit/phpunit' => '^9.5',
        ],
    ]);
};
