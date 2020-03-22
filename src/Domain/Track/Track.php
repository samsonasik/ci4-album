<?php namespace Album\Domain\Track;

use CodeIgniter\Entity;

/**
 * @property int $id
 * @property int $album_id
 * @property string $title
 */
class Track extends Entity
{
	public function __construct(array $data = null)
	{
		$data['album_id'] = $data['album_id'] ?? 0;
		$data['title']    = $data['title'] ?? '';

		parent::__construct($data);
	}

	public function setTitle(string $title): self
	{
		$this->attributes['title'] = ucwords($title);
		return $this;
	}
}
