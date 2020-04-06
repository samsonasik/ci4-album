<?php

namespace AlbumTest\Unit\Domain\Album;

use Album\Domain\Album\AlbumNotFoundException;
use Error;
use PHPUnit\Framework\TestCase;

class AlbumNotFoundExceptionTest extends TestCase
{
	public function testCannotInstantiateDirectly()
	{
		$this->expectException(Error::class);
		new AlbumNotFoundException('message');
	}

	public function testInstantiateforAlbumDoesnotExistOfId()
	{
		$this->assertInstanceOf(
			AlbumNotFoundException::class,
			AlbumNotFoundException::forAlbumDoesnotExistOfId(1)
		);
	}
}
