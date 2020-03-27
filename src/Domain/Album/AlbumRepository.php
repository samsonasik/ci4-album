<?php namespace Album\Domain\Album;

use Album\Domain\Repository;

interface AlbumRepository extends Repository
{
	public function findPaginatedData(string $keyword = ''): ?array;
	public function findAlbumOfId(int $id): Album;
}
