<?php

declare(strict_types=1);

use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine) {
    $emDefault = $doctrine->orm()
        ->entityManager('default');

    $emDefault->autoMapping(true);
    $emDefault
        ->mapping('CongregationManagerCongregationBundle')
        ->isBundle(true)
        ->type('xml')
        ->dir('config/doctrine')
        ->prefix('CongregationManager\Component\Congregation\Domain')
        ->alias('CongregationManagerCongregationBundle')
    ;
};
