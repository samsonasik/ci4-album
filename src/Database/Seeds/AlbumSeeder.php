<?php namespace Album\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlbumSeeder extends Seeder
{
	public function run()
	{
		$row = [
			'id'     => 1,
			'artist' => 'Sheila On 7',
			'title'  => 'Kisah Klasik Untuk Masa Depan',
		];

		$this->db->table('album')->insert($row);
	}
}
