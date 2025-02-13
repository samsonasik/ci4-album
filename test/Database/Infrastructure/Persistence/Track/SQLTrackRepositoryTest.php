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
use Album\Database\Seeds\TrackSeeder;
use Album\Domain\Album\Album;
use Album\Domain\Exception\DuplicatedRecordException;
use Album\Domain\Track\Track;
use Album\Domain\Track\TrackNotFoundException;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\Database;
use Config\Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;

/**
 * @internal
 */
final class SQLTrackRepositoryTest extends CIUnitTestCase
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
     * @var list<class-string>
     */
    protected $seed = [
        AlbumSeeder::class,
        TrackSeeder::class,
    ];

    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Services::trackRepository();
    }

    public function testfindPaginatedDataWithKeywordNotFoundInDB(): void
    {
        $album     = new Album();
        $album->id = 1;

        $tracks = $this->repository->findPaginatedData($album, 'Pak Ngah');
        $this->assertEmpty($tracks);
    }

    public function testfindPaginatedDataWithKeywordFoundInDB(): void
    {
        $album     = new Album();
        $album->id = 1;

        $tracks = $this->repository->findPaginatedData($album, 'Eross Chandra');
        $this->assertNotEmpty($tracks);
    }

    public function testFindTrackOfIdWithNotFoundIdInDatabase(): void
    {
        $this->expectException(TrackNotFoundException::class);
        $this->repository->findTrackOfId(random_int(1000, 2000));
    }

    public function testFindTrackOfIdWithFoundIdInDatabase(): void
    {
        $this->assertInstanceOf(Track::class, $this->repository->findTrackOfId(1));
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
     * @return array{insert: array<int, array{album_id: int, title: string, author: string}>, update: array<int, array{id: int, album_id: int, title: string, author: string}>}
     */
    public static function validData(): array
    {
        return [
            'insert' => [
                [
                    'album_id' => 1,
                    'title'    => 'Sahabat Sejati',
                    'author'   => 'Erros Chandra',
                ],
            ],
            'update' => [
                [
                    'id'       => 1,
                    'album_id' => 1,
                    'title'    => 'Temani Aku',
                    'author'   => 'Erros Chandra',
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

    public function testDeleteTrackOfIdWithNotFoundIdInDatabase(): void
    {
        $this->expectException(TrackNotFoundException::class);
        $this->repository->deleteOfId(random_int(1000, 2000));
    }

    public function testDeleteTrackOfIdWithFoundIdInDatabase(): void
    {
        $this->assertTrue($this->repository->deleteOfId(1));
    }

    public function testSaveDuplicateDataInsert(): void
    {
        $this->assertTrue($this->repository->save(
            [
                'album_id' => 1,
                'title'    => 'Sahabat Sejati',
                'author'   => 'Erros Chandra',
            ],
        ));

        $this->expectException(DuplicatedRecordException::class);
        $this->repository->save(
            [
                'album_id' => 1,
                'title'    => 'Sahabat Sejati',
                'author'   => 'Erros Chandra',
            ],
        );
    }

    public function testSaveDuplicateDataUpdate(): void
    {
        $this->assertTrue($this->repository->save(
            [
                'album_id' => 1,
                'title'    => 'Sahabat Sejati',
                'author'   => 'Erros Chandra',
            ],
        ));

        $this->assertTrue($this->repository->save(
            [
                'album_id' => 1,
                'title'    => 'Temani Aku',
                'author'   => 'Erros Chandra',
            ],
        ));

        $lastId = Database::connect()->insertID();

        $this->expectException(DuplicatedRecordException::class);
        $this->repository->save(
            [
                'id'       => $lastId,
                'album_id' => 1,
                'title'    => 'Sahabat Sejati',
                'author'   => 'Erros Chandra',
            ],
        );
    }
}
