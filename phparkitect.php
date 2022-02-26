<?php
declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\DependsOnlyOnTheseNamespaces;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $mvcClassSet = ClassSet::fromDir(__DIR__.'/src');

    $rules = [];

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('CongregationManager\Domain'))
        ->should(new NotHaveDependencyOutsideNamespace('CongregationManager\Domain', [
            InvalidArgumentException::class,
            DateTimeInterface::class
        ]))
        ->because('Domain should not have external dependencies');

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('CongregationManager\Application'))
        ->should(
            new DependsOnlyOnTheseNamespaces(
                'CongregationManager\Domain',
            )
        )
        ->because('Application should depend only on domain.');

    $config
        ->add($mvcClassSet, ...$rules);
};
