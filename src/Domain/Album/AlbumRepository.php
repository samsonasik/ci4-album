<?php namespace Album\Domain\Album;

use CodeIgniter\Pager\PagerInterface;

interface AlbumRepository
{
	public function findPaginatedData(string $keyword = ''): ?array;
	public function pager(): ?PagerInterface;
	public function findAlbumOfId(int $id): Album;
	public function save(array $data): bool;
	public function errors(): ?array;
	public function deleteOfId(int $id): bool;
}
