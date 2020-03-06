<?php namespace AlbumTest\Controller;

use Album\Controllers\Album;
use CodeIgniter\Test\CIDatabaseTestCase;
use CodeIgniter\Test\ControllerTester;

class AlbumControllerTest extends CIDatabaseTestCase
{
    use ControllerTester;

    protected $basePath =  __DIR__ . '/../src/Database/';
    protected $namespace = 'Album';

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

    public function testEditUnexistenceAlbum()
    {
        $result = $this->controller(Album::class)
                        ->execute('edit', 1);

        $this->assertEquals(404, $result->response()->getStatusCode());
    }

    public function testDeleteUnexistenceAlbum()
    {
        $result = $this->controller(Album::class)
                        ->execute('delete', 1);

        $this->assertEquals(404, $result->response()->getStatusCode());
    }
}