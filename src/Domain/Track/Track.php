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
	public function __construct(array $data = null)
	{
		if (! isset($data['album_id']))
		{
			throw new InvalidArgumentException('album_id key must be exists');
		}
		$data['title'] = $data['title'] ?? '';

		parent::__construct($data);
	}

	public function setTitle(string $title): self
	{
		$this->attributes['title'] = ucwords($title);
		return $this;
	}
}
