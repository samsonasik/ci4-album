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

use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Album\Controllers\Album;
use Album\Database\Seeds\AlbumSeeder;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\Database;
use Config\Services;

/**
 *
 *
 * @internal
 */
#[PreserveGlobalState(false)]
#[RunTestsInSeparateProcesses]
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

        $testResponse = $this->controller(Album::class)
            ->execute('index');

        $this->assertTrue($testResponse->isOK());
        $this->assertTrue($testResponse->see('No album found.'));
    }

    public function testIndexAlbumHasData(): void
    {
        $testResponse = $this->controller(Album::class)
            ->execute('index');

        $this->assertTrue($testResponse->isOK());
        $this->assertTrue($testResponse->see('Sheila On 7'));
    }

    public function testIndexSearchAlbumFound(): void
    {
        $request = Services::request();
        $request = $request->withMethod('get');
        $request->setGlobal('get', [
            'keyword' => 'Sheila',
        ]);

        $testResponse = $this->withRequest($request)
            ->controller(Album::class)
            ->execute('index');

        $this->assertTrue($testResponse->see('Sheila On 7'));
    }

    public function testIndexSearchAlbumNotFound(): void
    {
        $request = Services::request();
        $request = $request->withMethod('get');
        $request->setGlobal('get', [
            'keyword' => 'Siti',
        ]);

        $testResponse = $this->withRequest($request)
            ->controller(Album::class)
            ->execute('index');

        $this->assertTrue($testResponse->see('No album found.'));
    }

    public function testAddAlbum(): void
    {
        $testResponse = $this->controller(Album::class)
            ->execute('add');

        $this->assertTrue($testResponse->isOK());
    }

    #[DoesNotPerformAssertions]
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

        $testResponse = $this->withRequest($request)
            ->controller(Album::class)
            ->execute('add');

        $this->assertTrue($testResponse->isRedirect());
    }

    public function testEditUnexistenceAlbum(): void
    {
        $testResponse = $this->controller(Album::class)
            ->execute('edit', random_int(1000, 2000));

        $this->assertSame(404, $testResponse->response()->getStatusCode());
    }

    public function testEditExistenceAlbum(): void
    {
        $testResponse = $this->controller(Album::class)
            ->execute('edit', 1);

        $this->assertTrue($testResponse->isOK());
    }

    public function testEditAlbumInvalidData(): void
    {
        $request = Services::request(null, false);
        $request = $request->withMethod('post');

        $testResponse = $this->withRequest($request)
            ->controller(Album::class)
            ->execute('edit', 1);
        $this->assertTrue($testResponse->isRedirect());
        $this->assertNotSame('http://localhost:8080/index.php/album', $testResponse->getRedirectUrl());
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

        $testResponse = $this->withRequest($request)
            ->controller(Album::class)
            ->execute('edit', 1);

        $this->assertTrue($testResponse->isRedirect());
        $this->assertSame('http://localhost:8080/index.php/album', $testResponse->getRedirectUrl());
    }

    public function testDeleteUnexistenceAlbum(): void
    {
        $testResponse = $this->controller(Album::class)
            ->execute('delete', random_int(1000, 2000));

        $this->assertSame(404, $testResponse->response()->getStatusCode());
    }

    public function testDeleteExistenceAlbum(): void
    {
        $testResponse = $this->controller(Album::class)
            ->execute('delete', 1);

        $this->assertTrue($testResponse->isRedirect());
    }
}
