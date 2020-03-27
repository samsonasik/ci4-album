<?php namespace Album\Domain;

use CodeIgniter\Pager\PagerInterface;

interface Repository
{
	public function pager(): ?PagerInterface;
	public function save(array $data): bool;
	public function errors(): ?array;
	public function deleteOfId(int $id): bool;
}
