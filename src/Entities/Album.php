<?php namespace Album\Entities;

use CodeIgniter\Entity;

class Album extends Entity
{
	public function __construct(array $data = [])
	{
		$data['artist'] = $data['artist'] ?? '';
		$data['title']  = $data['title'] ?? '';

		parent::__construct($data);
	}

	public function setArtist(string $artist): self
	{
		$this->attributes['artist'] = ucwords($artist);
		return $this;
	}

	public function setTitle(string $title): self
	{
		$this->attributes['title'] = ucwords($title);
		return $this;
	}
}
