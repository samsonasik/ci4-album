<?php

namespace AlbumTest\Unit\Domain\Track;

use Album\Domain\Track\TrackNotFoundException;
use Error;
use PHPUnit\Framework\TestCase;

class TrackNotFoundExceptionTest extends TestCase
{
	public function testCannotInstantiateDirectly()
	{
		$this->expectException(Error::class);
		new TrackNotFoundException('message');
	}

	public function testInstantiateforAlbumTrackDoesnotExistOfId()
	{
		$this->assertInstanceOf(
			TrackNotFoundException::class,
			TrackNotFoundException::forAlbumTrackDoesnotExistOfId(1)
		);
	}
}
