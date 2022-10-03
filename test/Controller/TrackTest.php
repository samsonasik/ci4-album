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
 *
 * @preserveGlobalState         disabled
 *
 * @internal
 */
final class TrackTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use ControllerTestTrait;

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

    public function testIndexTrackByNotFoundAlbum(): void
    {
        $result = $this->controller(Track::class)
            ->execute('index', 2);

        $this->assertSame(404, $result->response()->getStatusCode());
    }

    public function testIndexTrackHasNoData(): void
    {
        Database::connect()->disableForeignKeyChecks();
        Database::connect()->table('track')->truncate();
        Database::connect()->enableForeignKeyChecks();

        $result = $this->controller(Track::class)
            ->execute('index', 1);

        $this->assertTrue($result->isOK());
        $this->assertTrue($result->see('No album track found.'));
    }

    public function testIndexTrackHasData(): void
    {
        $result = $this->controller(Track::class)
            ->execute('index', 1);

        $this->assertTrue($result->isOK());
        $this->assertTrue($result->see('Eross'));
    }

    public function testIndexSearchTrackFound(): void
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

    public function testIndexSearchTrackNotFound(): void
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

    public function testAddTrackByNotFoundAlbum(): void
    {
        $result = $this->controller(Track::class)
            ->execute('add', 2);

        $this->assertSame(404, $result->response()->getStatusCode());
    }

    public function testAddTrack(): void
    {
        $result = $this->controller(Track::class)
            ->execute('add', 1);

        $this->assertTrue($result->isOK());
    }

    public function testAddTrackInvalidData(): void
    {
        $request = Services::request(null, false);
        $request = $request->withMethod('post');

        $result = $this->withRequest($request)
            ->controller(Track::class)
            ->execute('add', 1);
        $this->assertTrue($result->isRedirect());
        $this->seeNumRecords(1, 'track', []);
    }

    public function testAddTrackValidData(): void
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

    public function testEditUnexistenceTrack(): void
    {
        $result = $this->controller(Track::class)
            ->execute('edit', random_int(1000, 2000), random_int(1000, 2000));

        $this->assertSame(404, $result->response()->getStatusCode());
    }

    public function testEditExistenceTrack(): void
    {
        $result = $this->controller(Track::class)
            ->execute('edit', 1, 1);

        $this->assertTrue($result->isOK());
    }

    public function testEditTrackInvalidData(): void
    {
        $request = Services::request(null, false);
        $request = $request->withMethod('post');

        $result = $this->withRequest($request)
            ->controller(Track::class)
            ->execute('edit', 1, 1);
        $this->assertTrue($result->isRedirect());
        $this->assertNotSame('http://localhost:8080/index.php/album-track/1', $result->getRedirectUrl());
    }

    public function testEditTrackValidData(): void
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
        $this->assertSame('http://localhost:8080/index.php/album-track/1', $result->getRedirectUrl());
    }

    public function testDeleteUnexistenceTrack(): void
    {
        $result = $this->controller(Track::class)
            ->execute('delete', random_int(1000, 2000), random_int(1000, 2000));

        $this->assertSame(404, $result->response()->getStatusCode());
    }

    public function testDeleteExistenceTrack(): void
    {
        $result = $this->controller(Track::class)
            ->execute('delete', 1, 1);

        $this->assertTrue($result->isRedirect());
    }
}
