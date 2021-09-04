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

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        $row = [
            'artist' => 'Sheila On 7',
            'title'  => 'Kisah Klasik Untuk Masa Depan',
        ];

        $this->db->table('album')->insert($row);
    }
}
