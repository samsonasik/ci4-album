<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Database\Seeds;

use CodeIgniter\Database\Seeder;

final class TrackSeeder extends Seeder
{
    /**
     * @var array<string, int|string>
     */
    private const ROW = [
        'album_id' => 1,
        'title'    => 'Sebuah Kisah Klasik',
        'author'   => 'Eross Chandra',
    ];

    public function run(): void
    {
        $this->db->table('track')->insert(self::ROW);
    }
}
