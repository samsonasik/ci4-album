<?php namespace AlbumTest\Controller;

use Album\Controllers\Album;
use AlbumTest\Database\Seeds\AlbumSeeder;
use CodeIgniter\Test\CIDatabaseTestCase;
use CodeIgniter\Test\ControllerTester;

class AlbumTest extends CIDatabaseTestCase
{
    use ControllerTester;

    protected $basePath  =  __DIR__ . '/../src/Database/';
    protected $namespace = 'Album';
    protected $seed      = AlbumSeeder::class;

    public function testIndexAlbum()
    {
        $result = $this->controller(Album::class)
                        ->execute('index');

        $this->assertTrue($result->isOK());
    }

    public function testAddAlbum()
    {
        $result = $this->controller(Album::class)
                        ->execute('add');

        $this->assertTrue($result->isOK());
    }

    public function testEditExistenceAlbum()
    {
        $result = $this->controller(Album::class)
                        ->execute('edit', 1);

        $this->assertTrue($result->isOK());
    }

    public function testEditUnexistenceAlbum()
    {
        $result = $this->controller(Album::class)
                        ->execute('edit', 1000);

        $this->assertEquals(404, $result->response()->getStatusCode());
    }

    public function testDeleteUnexistenceAlbum()
    {
        $result = $this->controller(Album::class)
                        ->execute('delete', 1000);

        $this->assertEquals(404, $result->response()->getStatusCode());
    }

    public function testDeleteExistenceAlbum()
    {
        $result = $this->controller(Album::class)
				       ->execute('delete', 1);

        $this->assertTrue($result->isRedirect());
    }
}