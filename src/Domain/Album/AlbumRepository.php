<?php namespace Album\Domain\Album;

use Album\Domain\DMLRepository;

interface AlbumRepository extends DMLRepository
{
	public function findPaginatedData(string $keyword = ''): ?array;
	public function findAlbumOfId(int $id): Album;
}
