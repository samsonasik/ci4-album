<?php namespace Album\Domain;

interface Repository
{
	public function save(array $data): bool;
	public function deleteOfId(int $id): bool;
}
