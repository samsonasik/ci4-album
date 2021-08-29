<?php

use CodeIgniter\CodingStandard\CodeIgniter4;
use Nexus\CsConfig\Factory;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->files()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/test',
    ])
    ->exclude(['Views']);

$options = [
    'finder' => $finder,
];

return Factory::create(new CodeIgniter4(), [], $options)
    ->forLibrary('samsonasik/ci4-album', 'Abdul Malik Ikhsan', 'samsonasik@gmail.com', 2020);