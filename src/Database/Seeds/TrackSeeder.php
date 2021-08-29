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

class TrackSeeder extends Seeder
{
    public function run()
    {
        $row = [
            'album_id' => 1,
            'title'    => 'Sebuah Kisah Klasik',
            'author'   => 'Eross Chandra',
        ];

        $this->db->table('track')->insert($row);
    }
}
