<?php namespace Album\Domain\Track;

use Album\Domain\Album\Album;
use Album\Domain\Repository;

interface TrackRepository extends Repository
{
	public function findPaginatedData(Album $album, string $keyword = ''): ?array;
	public function findTrackOfId(int $id): Track;
}
