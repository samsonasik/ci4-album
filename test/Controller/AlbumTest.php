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

use Album\Controllers\Album;
use Album\Database\Seeds\AlbumSeeder;
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
final class AlbumTest extends CIUnitTestCase
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
     * @var string
     */
    protected $seed = AlbumSeeder::class;

    public function testIndexAlbumHasNoData(): void
    {
        Database::connect()->disableForeignKeyChecks();
        Database::connect()->table('album')->truncate();
        Database::connect()->enableForeignKeyChecks();

        $result = $this->controller(Album::class)
            ->execute('index');

        $this->assertTrue($result->isOK());
        $this->assertTrue($result->see('No album found.'));
    }

    public function testIndexAlbumHasData(): void
    {
        $result = $this->controller(Album::class)
            ->execute('index');

        $this->assertTrue($result->isOK());
        $this->assertTrue($result->see('Sheila On 7'));
    }

    public function testIndexSearchAlbumFound(): void
    {
        $request = Services::request();
        $request = $request->withMethod('get');
        $request->setGlobal('get', [
            'keyword' => 'Sheila',
        ]);

        $result = $this->withRequest($request)
            ->controller(Album::class)
            ->execute('index');

        $this->assertTrue($result->see('Sheila On 7'));
    }

    public function testIndexSearchAlbumNotFound(): void
    {
        $request = Services::request();
        $request = $request->withMethod('get');
        $request->setGlobal('get', [
            'keyword' => 'Siti',
        ]);

        $result = $this->withRequest($request)
            ->controller(Album::class)
            ->execute('index');

        $this->assertTrue($result->see('No album found.'));
    }

    public function testAddAlbum(): void
    {
        $result = $this->controller(Album::class)
            ->execute('add');

        $this->assertTrue($result->isOK());
    }

    public function testAddAlbumInvalidData(): void
    {
        $request = Services::request(null, false);
        $request = $request->withMethod('post');

        $this->withRequest($request)
            ->controller(Album::class)
            ->execute('add');

        $this->seeNumRecords(1, 'album', []);
    }

    public function testAddAlbumValidData(): void
    {
        $request = Services::request();
        $request = $request->withMethod('post');
        $request->setGlobal('post', [
            'artist' => 'Siti Nurhaliza',
            'title'  => 'Anugrah Aidilfitri',
        ]);

        $result = $this->withRequest($request)
            ->controller(Album::class)
            ->execute('add');

        $this->assertTrue($result->isRedirect());
    }

    public function testEditUnexistenceAlbum(): void
    {
        $result = $this->controller(Album::class)
            ->execute('edit', random_int(1000, 2000));

        $this->assertSame(404, $result->response()->getStatusCode());
    }

    public function testEditExistenceAlbum(): void
    {
        $result = $this->controller(Album::class)
            ->execute('edit', 1);

        $this->assertTrue($result->isOK());
    }

    public function testEditAlbumInvalidData(): void
    {
        $request = Services::request(null, false);
        $request = $request->withMethod('post');

        $result = $this->withRequest($request)
            ->controller(Album::class)
            ->execute('edit', 1);
        $this->assertTrue($result->isRedirect());
        $this->assertNotSame('http://localhost:8080/index.php/album', $result->getRedirectUrl());
    }

    public function testEditAlbumValidData(): void
    {
        $request = Services::request();
        $request = $request->withMethod('post');
        $request->setGlobal('post', [
            'id'     => 1,
            'artist' => 'Siti Nurhaliza',
            'title'  => 'Anugrah Aidilfitri',
        ]);

        $result = $this->withRequest($request)
            ->controller(Album::class)
            ->execute('edit', 1);

        $this->assertTrue($result->isRedirect());
        $this->assertSame('http://localhost:8080/index.php/album', $result->getRedirectUrl());
    }

    public function testDeleteUnexistenceAlbum(): void
    {
        $result = $this->controller(Album::class)
            ->execute('delete', random_int(1000, 2000));

        $this->assertSame(404, $result->response()->getStatusCode());
    }

    public function testDeleteExistenceAlbum(): void
    {
        $result = $this->controller(Album::class)
            ->execute('delete', 1);

        $this->assertTrue($result->isRedirect());
    }
}
