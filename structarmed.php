<?php

declare(strict_types=1);

use Boundwize\StructArmed\Architecture;
use Boundwize\StructArmed\Preset\Preset;

return Architecture::define()
    ->skip([
        \Boundwize\StructArmed\Preset\Presets\Psr4Preset::CLASSES_MUST_MATCH_COMPOSER => [
            __DIR__ . '/src/Database/Migrations',
        ],
    ])
    ->withPreset(Preset::PSR4());