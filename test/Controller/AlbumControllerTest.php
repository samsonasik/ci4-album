<?php namespace AlbumTest\Controller;

use Album\Controllers\Album;
use CodeIgniter\Test\CIDatabaseTestCase;
use CodeIgniter\Test\ControllerTester;

class AlbumControllerTest extends CIDatabaseTestCase
{
    use ControllerTester;

    protected $basePath =  __DIR__ . '/../src/Database/';
    protected $namespace = 'Album';

    protected function setUp(): void
    {
        parent::setUp();
    }

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
}