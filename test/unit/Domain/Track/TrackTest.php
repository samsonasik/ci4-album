<?php

namespace AlbumTest\Unit\Domain\Track;

use Album\Domain\Track\Track;
use PHPUnit\Framework\TestCase;

class TrackTest extends TestCase
{
	private $entity;

	protected function setUp(): void
	{
		$this->entity = new Track();
	}

	public function testSetAlbumId()
	{
		$this->entity->setAlbumId(1);
		$this->assertEquals(1, $this->entity->album_id);
	}

	public function testSetTitle()
	{
		$this->entity->setTitle('sebuah kisah klasik');
		$this->assertEquals('Sebuah Kisah Klasik', $this->entity->title);
	}

	public function testSetAuthor()
	{
		$this->entity->setAuthor('eross chandra');
		$this->assertEquals('Eross Chandra', $this->entity->author);
	}
}
