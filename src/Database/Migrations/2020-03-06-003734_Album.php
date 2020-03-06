<?php namespace Album\Database\Migrations;

use CodeIgniter\Database\Migration;

class Album extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
					'type'           => 'BIGINT',
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
			],
			'artist'       => [
					'type'           => 'VARCHAR',
					'constraint'     => '255',
			],
			'title' => [
					'type'           => 'VARCHAR',
					'constraint'     => '255',
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('album');
	}

	public function down()
	{
		$this->forge->dropTable('album');
	}
}
