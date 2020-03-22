<?php namespace Album\Domain\Track;

use Album\Domain\Repository;

interface TrackRepository extends Repository
{
	public function findPaginatedData(int $albumId, string $keyword = ''): ?array;
	public function findTrackOfId(int $id): Track;
}
