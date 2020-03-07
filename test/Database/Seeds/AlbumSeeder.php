<?php namespace AlbumTest\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlbumSeeder extends Seeder
{
	public function run()
	{
		$row = [
			'id'     => 1,
			'artist' => 'Sheila On 7',
			'title'  => 'Melompat Lebih Tinggi',
		];

		$this->db->table('album')->insert($row);
	}
}
