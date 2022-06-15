<?php

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    // A. full sets
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::PHP_CS_FIXER);
    $containerConfigurator->import(SetList::CLEAN_CODE);
    $containerConfigurator->import(SetList::SYMPLIFY);
    $containerConfigurator->import(SetList::ARRAY);
    $containerConfigurator->import(SetList::COMMON);
    $containerConfigurator->import(SetList::COMMENTS);
    $containerConfigurator->import(SetList::DOCBLOCK);
    $containerConfigurator->import(SetList::NAMESPACES);
    $containerConfigurator->import(SetList::PHPUNIT);
    $containerConfigurator->import(SetList::SPACES);
    $containerConfigurator->import(SetList::STRICT);
    $containerConfigurator->import(SetList::SYMFONY);

    // B. standalone rule
    $services = $containerConfigurator->services();
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);
};
