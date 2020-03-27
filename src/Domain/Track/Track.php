<?php namespace Album\Domain\Track;

use CodeIgniter\Entity;
use InvalidArgumentException;

/**
 * @property int $id
 * @property int $album_id
 * @property string $title
 */
class Track extends Entity
{
	protected $attributes = [
		'id'       => null,
		'album_id' => null,
		'title'    => null,
		'author'   => null,
	];

	public function setTitle(string $title): self
	{
		$this->attributes['title'] = ucwords($title);
		return $this;
	}

	public function setAuthor(string $author): self
	{
		$this->attributes['author'] = ucwords($author);
		return $this;
	}
}
