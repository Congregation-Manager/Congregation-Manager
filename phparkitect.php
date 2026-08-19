<?php
declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\DependsOnlyOnTheseNamespaces;
use Arkitect\Expression\ForClasses\NotDependsOnTheseNamespaces;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $mvcClassSet = ClassSet::fromDir(__DIR__.'/src');

    $rules = [];

    $contracts = ['Resource'];
    foreach ($contracts as $contract) {
        $rules[] = Rule::allClasses()
            ->that(new ResideInOneOfTheseNamespaces("CongregationManager\Contract\\$contract"))
            ->should(new NotHaveDependencyOutsideNamespace("CongregationManager\Contract\\$contract", [
                InvalidArgumentException::class,
                DateTimeImmutable::class,
            ]))
            ->because('Contracts should not have any external dependencies.');
    }

    $components = ['Congregation', 'TerritoryManager', 'User'];
    foreach ($components as $component) {
        $rules[] = Rule::allClasses()
            ->that(new ResideInOneOfTheseNamespaces("CongregationManager\Component\\$component\Domain"))
            ->should(
                new DependsOnlyOnTheseNamespaces([
                        'CongregationManager\Contract',
                        "CongregationManager\Component\\$component\Domain",
                        'Doctrine\Common\Collections',
                ])
            )
            ->because("$component domain component should depends only from contracts.");

        $rules[] = Rule::allClasses()
            ->that(new ResideInOneOfTheseNamespaces("CongregationManager\Component\\$component\Application"))
            ->should(
                new DependsOnlyOnTheseNamespaces([
                        'CongregationManager\Contract',
                        "CongregationManager\Component\\$component\Domain",
                        "CongregationManager\Component\\$component\Application",
                        'Doctrine\Common\Collections',
                ])
            )
            ->because("$component application component should depends only from contracts or domain.");

        $rules[] = Rule::allClasses()
            ->that(new ResideInOneOfTheseNamespaces("CongregationManager\Component\\$component\Infrastructure"))
            ->should(
                new DependsOnlyOnTheseNamespaces([
                        'CongregationManager\Contract',
                        "CongregationManager\Component\\$component\Domain",
                        "CongregationManager\Component\\$component\Application",
                        "CongregationManager\Component\\$component\Infrastructure",
                        'Doctrine\Common\Collections',
                ])
            )
            ->because("$component infrastructure component should depends only from contracts, domain or application.");
    }

    $coreDomainDependencies = [];
    $coreApplicationDependencies = [];
    $coreInfrastructureDependencies = [];
    foreach ($components as $component) {
        $coreDomainDependencies[] = "CongregationManager\Component\\$component\Domain";
        $coreApplicationDependencies[] = "CongregationManager\Component\\$component\Application";
        $coreInfrastructureDependencies[] = "CongregationManager\Component\\$component\Infrastructure";
    }
    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('CongregationManager\Component\Core\Domain'))
        ->should(
            new DependsOnlyOnTheseNamespaces([
                    'CongregationManager\Contract',
                    'CongregationManager\Component\Core\Domain',
                    'Doctrine\Common\Collections',
                    ...$coreDomainDependencies,
            ])
        )
        ->because("Core domain component should depends only from contracts or other component domains.");
    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('CongregationManager\Component\Core\Application'))
        ->should(
            new DependsOnlyOnTheseNamespaces([
                    'CongregationManager\Contract',
                    'CongregationManager\Component\Core\Domain',
                    'CongregationManager\Component\Core\Application',
                    'Doctrine\Common\Collections',
                    ...$coreDomainDependencies,
                    ...$coreApplicationDependencies,
            ])
        )
        ->because("Core application component should depends only from contracts or other component domains and applications.");
    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('CongregationManager\Component\Core\Infrastructure'))
        ->should(
            new DependsOnlyOnTheseNamespaces([
                    'CongregationManager\Contract',
                    'CongregationManager\Component\Core\Domain',
                    'CongregationManager\Component\Core\Application',
                    'CongregationManager\Component\Core\Infrastructure',
                    'Doctrine\Common\Collections',
                    ...$coreDomainDependencies,
                    ...$coreApplicationDependencies,
                    ...$coreInfrastructureDependencies,
            ])
        )
        ->because("Core infrastructure component should depends only from contracts or other component domains, applications and infrastructures.");

    $config
        ->add($mvcClassSet, ...$rules);
};
