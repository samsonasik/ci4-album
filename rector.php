<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector;

return RectorConfig::configure()
    ->withPreparedSets(
        codeQuality: true,
        deadCode: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        codingStyle: true
    )
    ->withPhpSets(php81: true)
    ->withPaths([__DIR__ . '/src', __DIR__ . '/test'])
    ->withRootFiles()
    ->withImportNames()
    ->withSkip([
        // make error on controller load view
        StringClassNameToClassConstantRector::class,
        // conflict with cs fix
        NewlineAfterStatementRector::class,
    ])
    ->withBootstrapFiles(
        [__DIR__ . '/bootstrap.php']
    )
    ->withPHPStanConfigs([__DIR__ . '/phpstan.neon']);
