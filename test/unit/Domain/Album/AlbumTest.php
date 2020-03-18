<?php

namespace AlbumTest\Unit\Domain\Album;

use Album\Domain\Album\Album;
use PHPUnit\Framework\TestCase;

class AlbumTest extends TestCase
{
	private $entity;

	protected function setUp(): void
	{
		$this->entity = new Album();
	}

	public function testSetArtist()
	{
		$this->entity->setArtist('sheila on 7');
		$this->assertEquals('Sheila On 7', $this->entity->artist);
	}

	public function testSetTitle()
	{
		$this->entity->setTitle('melompat lebih tinggi');
		$this->assertEquals('Melompat Lebih Tinggi', $this->entity->title);
	}
}
