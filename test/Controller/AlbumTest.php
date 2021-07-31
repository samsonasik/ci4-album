<?php namespace AlbumTest\Controller;

use Album\Controllers\Album;
use Album\Database\Seeds\AlbumSeeder;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\Database;
use Config\Services;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class AlbumTest extends CIUnitTestCase
{
	use DatabaseTestTrait, ControllerTestTrait;

	protected $basePath  = __DIR__ . '/../src/Database/';
	protected $namespace = 'Album';
	protected $seed      = AlbumSeeder::class;

	public function testIndexAlbumHasNoData()
	{
		Database::connect()->disableForeignKeyChecks();
		Database::connect()->table('album')->truncate();
		Database::connect()->enableForeignKeyChecks();

		$result = $this->controller(Album::class)
						->execute('index');

		$this->assertTrue($result->isOK());
		$this->assertTrue($result->see('No album found.'));
	}

	public function testIndexAlbumHasData()
	{
		$result = $this->controller(Album::class)
						->execute('index');

		$this->assertTrue($result->isOK());
		$this->assertTrue($result->see('Sheila On 7'));
	}

	public function testIndexSearchAlbumFound()
	{
		$request = Services::request();
		$request = $request->withMethod('get');
		$request->setGlobal('get', [
			'keyword' => 'Sheila',
		]);

		$result = $this->withRequest($request)
					   ->controller(Album::class)
					   ->execute('index');

		$this->assertTrue($result->see('Sheila On 7'));
	}

	public function testIndexSearchAlbumNotFound()
	{
		$request = Services::request();
		$request = $request->withMethod('get');
		$request->setGlobal('get', [
			'keyword' => 'Siti',
		]);

		$result = $this->withRequest($request)
					   ->controller(Album::class)
					   ->execute('index');

		$this->assertTrue($result->see('No album found.'));
	}

	public function testAddAlbum()
	{
		$result = $this->controller(Album::class)
						->execute('add');

		$this->assertTrue($result->isOK());
	}

	public function testAddAlbumInvalidData()
	{
		$request = Services::request(null, false);
		$request = $request->withMethod('post');

		$this->withRequest($request)
			 ->controller(Album::class)
			 ->execute('add');

		$this->seeNumRecords(1, 'album', []);
	}

	public function testAddAlbumValidData()
	{
		$request = Services::request();
		$request = $request->withMethod('post');
		$request->setGlobal('post', [
			'artist' => 'Siti Nurhaliza',
			'title'  => 'Anugrah Aidilfitri',
		]);

		$result = $this->withRequest($request)
					   ->controller(Album::class)
					   ->execute('add');

		$this->assertTrue($result->isRedirect());
	}

	public function testEditUnexistenceAlbum()
	{
		$result = $this->controller(Album::class)
						->execute('edit', random_int(1000, 2000));

		$this->assertEquals(404, $result->response()->getStatusCode());
	}

	public function testEditExistenceAlbum()
	{
		$result = $this->controller(Album::class)
						->execute('edit', 1);

		$this->assertTrue($result->isOK());
	}

	public function testEditAlbumInvalidData()
	{
		$request = Services::request(null, false);
		$request = $request->withMethod('post');

		$result = $this->withRequest($request)
						->controller(Album::class)
						->execute('edit', 1);
		$this->assertTrue($result->isRedirect());
		$this->assertNotEquals('http://localhost:8080/index.php/album', $result->getRedirectUrl());
	}

	public function testEditAlbumValidData()
	{
		$request = Services::request();
		$request = $request->withMethod('post');
		$request->setGlobal('post', [
			'id'     => 1,
			'artist' => 'Siti Nurhaliza',
			'title'  => 'Anugrah Aidilfitri',
		]);

		$result = $this->withRequest($request)
					   ->controller(Album::class)
					   ->execute('edit', 1);

		$this->assertTrue($result->isRedirect());
		$this->assertEquals('http://localhost:8080/index.php/album', $result->getRedirectUrl());
	}

	public function testDeleteUnexistenceAlbum()
	{
		$result = $this->controller(Album::class)
						->execute('delete', random_int(1000, 2000));

		$this->assertEquals(404, $result->response()->getStatusCode());
	}

	public function testDeleteExistenceAlbum()
	{
		$result = $this->controller(Album::class)
					   ->execute('delete', 1);

		$this->assertTrue($result->isRedirect());
	}
}
