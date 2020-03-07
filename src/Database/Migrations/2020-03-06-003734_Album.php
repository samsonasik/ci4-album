<?php namespace Album\Database\Migrations;

use CodeIgniter\Database\Migration;

class Album extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'     => [
				'type'           => 'BIGINT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'artist' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'title'  => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('album');
	}

	public function down()
	{
		$this->forge->dropTable('album');
	}
}
