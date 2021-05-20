<?php namespace AlbumTest\Controller;

use Album\Controllers\Track;
use Album\Database\Seeds\AlbumSeeder;
use Album\Database\Seeds\TrackSeeder;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\Database;
use Config\Services;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 */
class TrackTest extends CIUnitTestCase
{
	use DatabaseTestTrait, ControllerTestTrait;

	protected $basePath  = __DIR__ . '/../src/Database/';
	protected $namespace = 'Album';
	protected $seed      = [
		AlbumSeeder::class,
		TrackSeeder::class,
	];

	public function testIndexTrackByNotFoundAlbum()
	{
		$result = $this->controller(Track::class)
						->execute('index', 2);

		$this->assertEquals(404, $result->response()->getStatusCode());
	}

	public function testIndexTrackHasNoData()
	{
		Database::connect()->disableForeignKeyChecks();
		Database::connect()->table('track')->truncate();
		Database::connect()->enableForeignKeyChecks();

		$result = $this->controller(Track::class)
						->execute('index', 1);

		$this->assertTrue($result->isOK());
		$this->assertTrue($result->see('No album track found.'));
	}

	public function testIndexTrackHasData()
	{
		$result = $this->controller(Track::class)
						->execute('index', 1);

		$this->assertTrue($result->isOK());
		$this->assertTrue($result->see('Eross'));
	}

	public function testIndexSearchTrackFound()
	{
		$request = Services::request();
		$request = $request->withMethod('get');
		$request->setGlobal('get', [
			'keyword' => 'kisah',
		]);

		$result = $this->withRequest($request)
					   ->controller(Track::class)
					   ->execute('index', 1);

		$this->assertTrue($result->see('Sebuah Kisah Klasik'));
	}

	public function testIndexSearchTrackNotFound()
	{
		$request = Services::request();
		$request = $request->withMethod('get');
		$request->setGlobal('get', [
			'keyword' => 'Purnama',
		]);

		$result = $this->withRequest($request)
					   ->controller(Track::class)
					   ->execute('index', 1);

		$this->assertTrue($result->see('No album track found.'));
	}

	public function testAddTrackByNotFoundAlbum()
	{
		$result = $this->controller(Track::class)
						->execute('add', 2);

		$this->assertEquals(404, $result->response()->getStatusCode());
	}

	public function testAddTrack()
	{
		$result = $this->controller(Track::class)
						->execute('add', 1);

		$this->assertTrue($result->isOK());
	}

	public function testAddTrackInvalidData()
	{
		$request = Services::request(null, false);
		$request = $request->withMethod('post');

		$result = $this->withRequest($request)
						->controller(Track::class)
						->execute('add', 1);
		$this->assertTrue($result->isRedirect());
		$this->seeNumRecords(1, 'track', []);
	}

	public function testAddTrackValidData()
	{
		$request = Services::request();
		$request = $request->withMethod('post');
		$request->setGlobal('post', [
			'album_id' => 1,
			'title'    => 'Sahabat Sejati',
			'author'   => 'Erros Chandra',
		]);

		$result = $this->withRequest($request)
					   ->controller(Track::class)
					   ->execute('add', 1);

		$this->assertTrue($result->isRedirect());
	}

	public function testEditUnexistenceTrack()
	{
		$result = $this->controller(Track::class)
						->execute('edit', rand(1000, 2000), rand(1000, 2000));

		$this->assertEquals(404, $result->response()->getStatusCode());
	}

	public function testEditExistenceTrack()
	{
		$result = $this->controller(Track::class)
						->execute('edit', 1, 1);

		$this->assertTrue($result->isOK());
	}

	public function testEditTrackInvalidData()
	{
		$request = Services::request(null, false);
		$request = $request->withMethod('post');

		$result = $this->withRequest($request)
						->controller(Track::class)
						->execute('edit', 1, 1);
		$this->assertTrue($result->isRedirect());
		$this->assertNotEquals('http://localhost:8080/index.php/album-track/1', $result->getRedirectUrl());
	}

	public function testEditTrackValidData()
	{
		$request = Services::request();
		$request = $request->withMethod('post');
		$request->setGlobal('post', [
			'id'       => 1,
			'album_id' => 1,
			'title'    => 'Temani Aku',
			'author'   => 'Erros Chandra',
		]);

		$result = $this->withRequest($request)
					   ->controller(Track::class)
					   ->execute('edit', 1, 1);

		$this->assertTrue($result->isRedirect());
		$this->assertEquals('http://localhost:8080/index.php/album-track/1', $result->getRedirectUrl());
	}

	public function testDeleteUnexistenceTrack()
	{
		$result = $this->controller(Track::class)
						->execute('delete', rand(1000, 2000), rand(1000, 2000));

		$this->assertEquals(404, $result->response()->getStatusCode());
	}

	public function testDeleteExistenceTrack()
	{
		$result = $this->controller(Track::class)
					   ->execute('delete', 1, 1);

		$this->assertTrue($result->isRedirect());
	}
}
