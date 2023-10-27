<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\FrameworkConfig;

/** @psalm-suppress UndefinedClass */
return static function (FrameworkConfig $framework): void {
    $uidConfig = $framework->uid();
    $uidConfig->defaultUuidVersion(7);
    $uidConfig->timeBasedUuidVersion(7);
};
