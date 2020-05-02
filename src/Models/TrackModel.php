<?php namespace Album\Models;

use Album\Domain\Track\Track;
use CodeIgniter\Model;

/**
 * @property-read \CodeIgniter\Database\MySQLi\Connection $db
 */
class TrackModel extends Model
{
	protected $table           = 'track';
	protected $returnType      = Track::class;
	protected $allowedFields   = [
		'album_id',
		'title',
		'author',
	];
	protected $validationRules = [
		'album_id' => 'required|numeric',
		'title'    => 'required|alpha_numeric_space|min_length[3]|max_length[255]|is_unique[track.title,id,{id}]',
		'author'   => 'required|alpha_numeric_space|min_length[3]|max_length[255]',
	];
}
