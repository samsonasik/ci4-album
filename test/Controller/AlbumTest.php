<?php namespace AlbumTest\Controller;

use Album\Controllers\Album;
use AlbumTest\Database\Seeds\AlbumSeeder;
use CodeIgniter\Test\CIDatabaseTestCase;
use CodeIgniter\Test\ControllerTester;
use Config\Database;
use Config\Services;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class AlbumTest extends CIDatabaseTestCase
{
	use ControllerTester;

	protected $basePath  = __DIR__ . '/../src/Database/';
	protected $namespace = 'Album';
	protected $seed      = AlbumSeeder::class;

	protected function setUp(): void
	{
		parent::setUp();
		\Config\Database::connect()->disableForeignKeyChecks();
	}

	public function testIndexAlbumHasNoData()
	{
		Database::connect()->table('album')->truncate();

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
		$request->setMethod('get');
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
		$request->setMethod('get');
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
		$request->setMethod('post');

		$result = $this->withRequest($request)
						->controller(Album::class)
						->execute('add');
		$this->assertTrue($result->isRedirect());

		$request = Services::request(null, false);
		$request->setMethod('get');

		$result = $this->withRequest($request)
					   ->controller(Album::class)
					   ->execute('add');
		$this->assertTrue($result->isOK());
		$this->assertTrue($result->see('The artist field is required.'));
		$this->assertTrue($result->see('The title field is required.'));
	}

	public function testAddAlbumValidData()
	{
		$request = Services::request();
		$request->setMethod('post');
		$request->setGlobal('post', [
			'artist' => 'Siti Nurhaliza',
			'title'  => 'Purnama Merindu',
		]);

		$result = $this->withRequest($request)
					   ->controller(Album::class)
					   ->execute('add');

		$this->assertTrue($result->isRedirect());
	}

	public function testEditUnexistenceAlbum()
	{
		$result = $this->controller(Album::class)
						->execute('edit', rand(1000, 2000));

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
		$request->setMethod('post');

		$result = $this->withRequest($request)
						->controller(Album::class)
						->execute('edit', 1);
		$this->assertTrue($result->isRedirect());

		$request = Services::request(null, false);
		$request->setMethod('get');

		$result = $this->withRequest($request)
					   ->controller(Album::class)
					   ->execute('edit', 1);
		$this->assertTrue($result->isOK());
		$this->assertTrue($result->see('The artist field is required.'));
		$this->assertTrue($result->see('The title field is required.'));
	}

	public function testEditAlbumValidData()
	{
		$request = Services::request();
		$request->setMethod('post');
		$request->setGlobal('post', [
			'artist' => 'Siti Nurhaliza',
			'title'  => 'Purnama Merindu',
		]);

		$result = $this->withRequest($request)
					   ->controller(Album::class)
					   ->execute('edit', 1);

		$this->assertTrue($result->isRedirect());
	}

	public function testDeleteUnexistenceAlbum()
	{
		$result = $this->controller(Album::class)
						->execute('delete', rand(1000, 2000));

		$this->assertEquals(404, $result->response()->getStatusCode());
	}

	public function testDeleteExistenceAlbum()
	{
		$result = $this->controller(Album::class)
					   ->execute('delete', 1);

		$this->assertTrue($result->isRedirect());
	}

	public function tearDown(): void
	{
		parent::tearDown();
		\Config\Database::connect()->enableForeignKeyChecks();
	}
}
