<?php

declare(strict_types=1);

use Boundwize\Pyrameter\Config\PyrameterConfig;
use Boundwize\Pyrameter\TestKind;

return PyrameterConfig::defaults()
    ->targetShape(
        unit: ['min' => 10],
        integration: ['max' => 40],
        functional: ['max' => 55],
    )
    ->failOnViolation();