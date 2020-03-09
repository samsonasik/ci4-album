<?php namespace Album\Models;

use AlbumTest\Database\Seeds\AlbumSeeder;
use CodeIgniter\Test\CIDatabaseTestCase;

class AlbumModelTest extends CIDatabaseTestCase
{
	protected $basePath  = __DIR__ . '/../src/Database/';
	protected $namespace = 'Album';
	protected $seed      = AlbumSeeder::class;
	private $model;

	protected function setUp(): void
	{
		parent::setUp();

		$this->model = model(AlbumModel::class);
	}

	public function testSearchKeywordForExistingData()
	{
		$albums = $this->model->getPaginatedData('Sheila')['albums'];
		$this->assertNotEmpty($albums);
	}

	public function testSearchKeywordForNonExistingData()
	{
		$albums = $this->model->getPaginatedData('Siti')['albums'];
		$this->assertEmpty($albums);
	}
}
