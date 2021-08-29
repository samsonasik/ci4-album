<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace AlbumTest\Controller;

use Album\Controllers\AlbumTrackSummary;
use Album\Database\Seeds\AlbumSeeder;
use Album\Database\Seeds\TrackSeeder;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\Database;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState         disabled
 *
 * @internal
 */
final class AlbumTrackSummaryTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    protected $basePath  = __DIR__ . '/../src/Database/';
    protected $namespace = 'Album';
    protected $seed      = [
        AlbumSeeder::class,
        TrackSeeder::class,
    ];

    public function testTotalSongSummaryHasNoData()
    {
        Database::connect()->disableForeignKeyChecks();
        Database::connect()->table('album')->truncate();
        Database::connect()->enableForeignKeyChecks();

        $result = $this->controller(AlbumTrackSummary::class)
            ->execute('totalsong');

        $this->assertTrue($result->isOK());
        $this->assertTrue($result->see('No album track summary found.'));
    }

    public function testTotalSongSummaryHasData()
    {
        $result = $this->controller(AlbumTrackSummary::class)
            ->execute('totalsong');

        $this->assertTrue($result->isOK());
        $this->assertMatchesRegularExpression('/Sheila On 7<\/td>\s{0,}\n\s{0,}<td>1<\/td>/', $result->getBody());
    }
}
