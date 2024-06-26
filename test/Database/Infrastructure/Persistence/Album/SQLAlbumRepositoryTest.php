<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace AlbumTest\Database\Infrastructure\Persistence\Album;

use Album\Database\Seeds\AlbumSeeder;
use Album\Domain\Album\Album;
use Album\Domain\Album\AlbumNotFoundException;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;

/**
 * @internal
 */
final class SQLAlbumRepositoryTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    /**
     * @var string
     */
    protected $basePath = __DIR__ . '/../src/Database/';

    /**
     * @var string
     */
    protected $namespace = 'Album';

    /**
     * @var string
     */
    protected $seed = AlbumSeeder::class;

    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Services::albumRepository();
    }

    public function testfindPaginatedDataWithKeywordNotFoundInDB(): void
    {
        $albums = $this->repository->findPaginatedData('Siti');
        $this->assertEmpty($albums);
    }

    public function testfindPaginatedDataWithKeywordFoundInDB(): void
    {
        $albums = $this->repository->findPaginatedData('Sheila');
        $this->assertNotEmpty($albums);
    }

    public function testFindAlbumOfIdWithNotFoundIdInDB(): void
    {
        $this->expectException(AlbumNotFoundException::class);
        $this->repository->findAlbumOfId(random_int(1000, 2000));
    }

    public function testFindAlbumOfIdWithFoundIdInDatabase(): void
    {
        $this->assertInstanceOf(Album::class, $this->repository->findAlbumOfId(1));
    }

    /**
     * @return array<string, list<mixed>>
     */
    public static function invalidData(): array
    {
        return [
            'empty array' => [
                [],
            ],
            'null' => [
                null,
            ],
        ];
    }

    /**
     * @param list<mixed>|null $data
     */
    #[DataProvider('invalidData')]
    public function testSaveInvalidData(?array $data): void
    {
        $this->assertFalse($this->repository->save($data));
    }

    /**
     * @return array{insert: array<int, array{artist: string, title: string}>, update: array<int, array{id: int, artist: string, title: string}>}
     */
    public static function validData(): array
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
     * @param array<string, int>|array<string, string> $data
     */
    #[DataProvider('validData')]
    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testSaveValidData(array $data): void
    {
        $this->assertTrue($this->repository->save($data));
    }

    public function testDeleteAlbumOfIdWithNotFoundIdInDatabase(): void
    {
        $this->expectException(AlbumNotFoundException::class);
        $this->repository->deleteOfId(random_int(1000, 2000));
    }

    public function testDeleteAlbumOfIdWithFoundIdInDatabase(): void
    {
        $this->assertTrue($this->repository->deleteOfId(1));
    }
}
