<?php namespace Album\Models;

use CodeIgniter\Database\MySQLi\Connection;
use Album\Domain\Album\Album;
use CodeIgniter\Model;

/**
 * @property-read Connection $db
 */
class AlbumModel extends Model
{
	protected $table           = 'album';
	protected $returnType      = Album::class;
	protected $allowedFields   = [
		'artist',
		'title',
	];
	protected $validationRules = [
		'artist' => 'required|alpha_numeric_space|min_length[3]|max_length[255]',
		'title'  => 'required|alpha_numeric_space|min_length[3]|max_length[255]|is_unique[album.title,id,{id}]',
	];
}
