<?php namespace AlbumTest\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TrackSeeder extends Seeder
{
	public function run()
	{
		$row = [
			'id'       => 1,
			'album_id' => 1,
			'title'    => 'Melompat Lebih Tinggi',
			'author'   => 'Eros Chandra',
		];

		$this->db->table('album')->insert($row);
	}
}
