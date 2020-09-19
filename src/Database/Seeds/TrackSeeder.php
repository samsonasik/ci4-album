<?php namespace Album\Database\Seeds;

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
