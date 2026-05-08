<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use CodeIgniter\CodingStandard\CodeIgniter4;
use Nexus\CsConfig\Factory;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->files()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/test',
    ])
    ->append([
        __FILE__,
        __DIR__ . '/rector.php',
        __DIR__ . '/structarmed.php',
    ])
    ->exclude(['Views']);

$options = [
    'finder' => $finder,
];

return Factory::create(new CodeIgniter4(), [], $options)
    ->forLibrary('samsonasik/ci4-album', 'Abdul Malik Ikhsan', 'samsonasik@gmail.com', 2020);
