<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Database\Migrations;

use CodeIgniter\Database\Migration;

final class Album extends Migration
{
    /**
     * @var string
     */
    private const TYPE = 'type';

    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                self::TYPE       => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'artist' => [
                self::TYPE   => 'VARCHAR',
                'constraint' => '255',
            ],
            'title' => [
                self::TYPE   => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('album');
    }

    public function down(): void
    {
        $this->forge->dropTable('album');
    }
}
