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

	public function setArtist(string $artist): void
	{
		$this->attributes['artist'] = ucwords($artist);
	}

	public function setTitle(string $title): void
	{
		$this->attributes['title'] = ucwords($title);
	}
}
