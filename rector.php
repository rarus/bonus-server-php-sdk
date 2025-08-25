<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src/',
        __DIR__.'/tests/',
    ])
    ->withCache(cacheDirectory: __DIR__.'.cache/rector')
    ->withSets(
        [
            PHPUnitSetList::PHPUNIT_100,
        ]
    )
    ->withImportNames(
        removeUnusedImports: true,
    )
    ->withPhpVersion(PhpVersion::PHP_82)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        strictBooleans: true
    )
    ->withSkip([
        RenamePropertyToMatchTypeRector::class,
    ]);
