<?php namespace Album\Domain\Track;

use Album\Domain\Album\Album;
use Album\Domain\DMLRepository;

interface TrackRepository extends DMLRepository
{
	public function findPaginatedData(Album $album, string $keyword = ''): ?array;
	public function findTrackOfId(int $id): Track;
}
