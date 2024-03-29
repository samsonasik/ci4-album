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

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        LevelSetList::UP_TO_PHP_81,
        SetList::DEAD_CODE,
        SetList::TYPE_DECLARATION,
        SetList::PRIVATIZATION,
        SetList::NAMING,
        SetList::CODING_STYLE
    ]);

    $rectorConfig->paths([__DIR__ . '/src', __DIR__ . '/test', __DIR__ . '/rector.php', __DIR__ . '/bootstrap.php']);

    $rectorConfig->importNames();
    $rectorConfig->skip([
        // make error on controller load view
        StringClassNameToClassConstantRector::class,
        // conflict with cs fix
        NewlineAfterStatementRector::class,
        FinalizeClassesWithoutChildrenRector::class => [
            __DIR__ . '/src/Domain/Exception/DuplicatedRecordException.php',
            __DIR__ . '/src/Domain/Exception/RecordNotFoundException.php',
        ],
    ]);

    $rectorConfig->bootstrapFiles([__DIR__ . '/bootstrap.php']);

    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon');
    $rectorConfig->parallel();
};
