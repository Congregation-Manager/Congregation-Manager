<?php

declare(strict_types=1);

use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine) {
    $emDefault = $doctrine->orm()->entityManager('default');

    $emDefault->autoMapping(true);
    $emDefault
        ->mapping('CongregationManagerUserBundle')
        ->isBundle(true)
        ->type('xml')
        ->dir('config/doctrine')
        ->prefix('CongregationManager\Bundle\User\Model')
        ->alias('CongregationManagerUserBundle')
    ;
};
