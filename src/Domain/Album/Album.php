<?php namespace Album\Domain\Album;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property string $artist
 * @property string $title
 */
class Album extends Entity
{
	protected $attributes = [
		'id'     => null,
		'artist' => null,
		'title'  => null,
	];

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
