<?php namespace Album\Database\Migrations;

use CodeIgniter\Database\Migration;

class Track extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'     => [
				'type'           => 'BIGINT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'album_id' => [
				'type'       => 'BIGINT',
				'unsigned'   => true,
			],
			'title'  => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'author'  => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('album_id', 'album', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('track');
	}

	public function down()
	{
		$this->forge->dropTable('track');
	}
}
