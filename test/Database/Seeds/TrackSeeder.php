<?php namespace AlbumTest\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TrackSeeder extends Seeder
{
	public function run()
	{
		$row = [
			'id'       => 1,
			'album_id' => 1,
			'title'    => 'Sebuah Kisah Klasik',
			'author'   => 'Eross Chandra',
		];

		$this->db->table('album')->insert($row);
	}
}
