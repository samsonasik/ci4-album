<?php namespace Album\Domain\Album;

use CodeIgniter\Entity;

/**
 * @property int $id
 * @property string $artist
 * @property string $title
 */
class Album extends Entity
{
	public function __construct(array $data = null)
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
