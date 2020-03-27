<?php

namespace AlbumTest\Unit\Domain\Track;

use Album\Domain\Track\Track;
use PHPUnit\Framework\TestCase;

class TrackTest extends TestCase
{
	public function testFillGetAttributes()
	{
		$entity = new Track([
			'id'       => 1,
			'album_id' => 1,
			'title'    => 'sebuah kisah klasik',
			'author'   => 'eross chandra',
		]);

		$this->assertEquals(1, $entity->id);
		$this->assertEquals(1, $entity->album_id);
		$this->assertEquals('Sebuah Kisah Klasik', $entity->title);
		$this->assertEquals('Eross Chandra', $entity->author);
	}
}
