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

return RectorConfig::configure()
    ->withPreparedSets(
        codeQuality: true,
        deadCode: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        codingStyle: true
    )
    ->withPhpSets(php82: true)
    ->withComposerBased(phpunit: true)
    ->withPaths([__DIR__ . '/src', __DIR__ . '/test'])
    ->withRootFiles()
    ->withImportNames(removeUnusedImports: true)
    ->withSkip([
        // conflict with cs fix
        NewlineAfterStatementRector::class,
    ])
    ->withBootstrapFiles(
        [__DIR__ . '/vendor/codeigniter4/framework/system/Test/bootstrap.php']
    )
    ->withPHPStanConfigs([__DIR__ . '/phpstan.neon']);
