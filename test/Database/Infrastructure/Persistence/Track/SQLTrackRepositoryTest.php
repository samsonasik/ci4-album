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
use Album\Domain\Track\Track;
use Album\Domain\Track\TrackNotFoundException;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\Services;

/**
 * @internal
 */
final class SQLTrackRepositoryTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $basePath  = __DIR__ . '/../src/Database/';
    protected $namespace = 'Album';
    protected $seed      = [
        AlbumSeeder::class,
        TrackSeeder::class,
    ];
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Services::trackRepository();
    }

    public function testfindPaginatedDataWithKeywordNotFoundInDB()
    {
        $album     = new Album();
        $album->id = 1;

        $tracks = $this->repository->findPaginatedData($album, 'Pak Ngah');
        $this->assertEmpty($tracks);
    }

    public function testfindPaginatedDataWithKeywordFoundInDB()
    {
        $album     = new Album();
        $album->id = 1;

        $tracks = $this->repository->findPaginatedData($album, 'Eross Chandra');
        $this->assertNotEmpty($tracks);
    }

    public function testFindTrackOfIdWithNotFoundIdInDatabase()
    {
        $this->expectException(TrackNotFoundException::class);
        $this->repository->findTrackOfId(random_int(1000, 2000));
    }

    public function testFindTrackOfIdWithFoundIdInDatabase()
    {
        $this->assertInstanceOf(Track::class, $this->repository->findTrackOfId(1));
    }

    public function invalidData()
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
     * @dataProvider invalidData
     *
     * @param mixed $data
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
     * @dataProvider validData
     * @runInSeparateProcess
     * @preserveGlobalState         disabled
     */
    public function testSaveValidData(array $data)
    {
        $this->assertTrue($this->repository->save($data));
    }

    public function testDeleteTrackOfIdWithNotFoundIdInDatabase()
    {
        $this->expectException(TrackNotFoundException::class);
        $this->repository->deleteOfId(random_int(1000, 2000));
    }

    public function testDeleteTrackOfIdWithFoundIdInDatabase()
    {
        $this->assertTrue($this->repository->deleteOfId(1));
    }
}
