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
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\Services;

/**
 * @internal
 */
final class SQLAlbumTrackSummaryRepositoryTest extends CIUnitTestCase
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
     * @var class-string[]
     */
    protected $seed = [
        AlbumSeeder::class,
        TrackSeeder::class,
    ];
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Services::albumTrackSummary();
    }

    public function testFindPaginatedSummaryTotalSongDataFoundInDB(): void
    {
        $albumtracksummary = $this->repository->findPaginatedSummaryTotalSongData();
        $this->assertNotEmpty($albumtracksummary);
    }
}
