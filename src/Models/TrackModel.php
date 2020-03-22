<?php namespace Album\Models;

use Album\Domain\Track\Track;
use CodeIgniter\Model;

class TrackModel extends Model
{
	protected $table           = 'track';
	protected $returnType      = Track::class;
	protected $allowedFields   = [
		'album_id',
		'title',
	];
	protected $validationRules = [
		'album_id' => 'required|numeric|is_unique[album.id,album_id,{album_id}]',
		'title'    => 'required|alpha_numeric_space|min_length[3]|max_length[255]|is_unique[track.title,id,{id}]',
	];
}
