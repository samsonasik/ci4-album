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

final class Track extends Migration
{
    /**
     * @var string
     */
    private const ID = 'id';

    /**
     * @var string
     */
    private const TYPE = 'type';

    public function up(): void
    {
        $this->forge->addField([
            self::ID => [
                self::TYPE       => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'album_id' => [
                self::TYPE => 'BIGINT',
                'unsigned' => true,
            ],
            'title' => [
                self::TYPE   => 'VARCHAR',
                'constraint' => '255',
            ],
            'author' => [
                self::TYPE   => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey(self::ID, true);
        $this->forge->addForeignKey('album_id', 'album', self::ID, 'CASCADE', 'CASCADE');
        $this->forge->createTable('track');
    }

    public function down(): void
    {
        $this->forge->dropTable('track');
    }
}
