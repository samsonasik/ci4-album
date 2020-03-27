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

	public function testPagerIsNullBeforeFindPaginatedDataCalled()
	{
		$this->assertNull($this->repository->pager());
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

	public function invalidData()
	{
		return [
			'empty array' => [
				[],
			],
			'null'        => [
				null
			],
		];
	}

	/**
	 * @dataProvider invalidData
	 */
	public function testSaveInvalidData($data)
	{
		$this->assertFalse($this->repository->save($data));
	}

	public function validData()
	{
		return [
			'insert' => [
				[
					'artist' => 'Siti Nurhaliza',
					'title'  => 'Anugrah Aidilfitri',
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

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState         disabled
	 */
	public function testErrorIsNullOnNoSaveCalled()
	{
		$this->assertNull($this->repository->errors());
	}

	/**
	 * @dataProvider validData
	 * @runInSeparateProcess
	 * @preserveGlobalState         disabled
	 */
	public function testErrorIsNullAfterSaveCalledWithValidData($data)
	{
		$this->repository->save($data);
		$this->assertNull($this->repository->errors());
	}

	/**
	 * @dataProvider invalidData
	 * @runInSeparateProcess
	 * @preserveGlobalState         disabled
	 */
	public function testErrorIsArrayAfterSaveCalledWithInValidData($data)
	{
		$this->repository->save($data);
		$this->assertIsArray($this->repository->errors());
	}

	public function testDeleteAlbumOfIdWithNotFoundIdInDatabase()
	{
		$this->expectException(AlbumNotFoundException::class);
		$this->repository->deleteOfId(rand(1000, 2000));
	}

	public function testDeleteAlbumOfIdWithFoundIdInDatabase()
	{
		$this->assertTrue($this->repository->deleteOfId(1));
	}
}
