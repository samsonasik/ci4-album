<?php

namespace AlbumTest\Unit\Domain\AlbumTrackSummary;

use Album\Domain\AlbumTrackSummary\AlbumTrackSummary;
use PHPUnit\Framework\TestCase;

class AlbumTrackSummaryTest extends TestCase
{
	public function testFillGetAttributes()
	{
		$entity = new AlbumTrackSummary([
			'id'         => 1,
			'artist'     => 'Sheila On 7',
			'title'      => 'Kisah Klasik Untuk Masa Depan',
			'total_song' => 1,
		]);

		$this->assertEquals(1, $entity->id);
		$this->assertEquals('Sheila On 7', $entity->artist);
		$this->assertEquals('Kisah Klasik Untuk Masa Depan', $entity->title);
		$this->assertEquals(1, $entity->total_song);
	}
}
