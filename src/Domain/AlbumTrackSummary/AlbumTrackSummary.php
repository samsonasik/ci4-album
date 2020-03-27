<?php namespace Album\Domain\AlbumTrackSummary;

use CodeIgniter\Entity;

/**
 * @property int $id
 * @property int $artist
 * @property string $title
 * @property string $total_song
 */
class AlbumTrackSummary extends Entity
{
	protected $attributes = [
		'id'         => null,
		'artist'     => null,
		'title'      => null,
		'total_song' => null,
	];
}
