<?php namespace AlbumTest\Database\Infrastructure\Persistence\Album;

use Album\Domain\Album\Album;
use Album\Domain\Album\AlbumNotFoundException;
use AlbumTest\Database\Seeds\AlbumSeeder;
use CodeIgniter\Pager\PagerInterface;
use CodeIgniter\Test\CIDatabaseTestCase;
use Config\Services;

class SQLAlbumRepositoryTest extends CIDatabaseTestCase
{
	protected $basePath  = __DIR__ . '/../src/Database/';
	protected $namespace = 'Album';
	protected $seed      = AlbumSeeder::class;
	private $repository;

	protected function setUp(): void
	{
		parent::setUp();

		$this->repository = Services::albumRepository();
	}

	public function testfindPaginatedDataWithKeywordNotFoundInDatabase()
	{
		$albums = $this->repository->findPaginatedData('Siti');
		$this->assertEmpty($albums);
	}

	public function testfindPaginatedDataWithKeywordFoundInDatabase()
	{
		$albums = $this->repository->findPaginatedData('Sheila');
		$this->assertNotEmpty($albums);
	}

	public function testPager()
	{
		$this->assertInstanceOf(PagerInterface::class, $this->repository->pager());
	}

	public function testFindAlbumOfIdWithNotFoundIdInDatabase()
	{
		$this->expectException(AlbumNotFoundException::class);
		$this->repository->findAlbumOfId(rand(1000, 2000));
	}

	public function testFindAlbumOfIdWithFoundIdInDatabase()
	{
		$this->assertInstanceOf(Album::class, $this->repository->findAlbumOfId(1));
	}

	public function testSaveInvalidData()
	{
		$this->assertFalse($this->repository->save([]));
	}

	public function validData()
	{
		return [
			'insert' => [
				[
					'artist' => 'Siti Nurhaliza',
					'title'  => 'Purnama Merindu',
				],
			],
			'update' => [
				[
					'id'     => 1,
					'artist' => 'Sheila On 7',
					'title'  => 'Pejantan Tangguh',
				],
			],
		];
	}

	/**
	 * @dataProvider validData
	 * @runInSeparateProcess
	 * @preserveGlobalState         disabled
	 */
	public function testSaveValidData(array $data)
	{
		$this->assertTrue($this->repository->save($data));
	}
}
