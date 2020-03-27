<?php

namespace AlbumTest\Unit\Domain\Album;

use Album\Domain\Album\Album;
use PHPUnit\Framework\TestCase;

class AlbumTest extends TestCase
{
	public function testFillGetAttributes()
	{
		$entity = new Album([
			'id'     => 1,
			'artist' => 'sheila on 7',
			'title'  => 'kisah klasik untuk masa depan',
		]);

		$this->assertEquals(1, $entity->id);
		$this->assertEquals('Sheila On 7', $entity->artist);
		$this->assertEquals('Kisah Klasik Untuk Masa Depan', $entity->title);
	}
}
