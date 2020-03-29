<?php namespace Album\Models;

use Album\Domain\Album\Album;
use CodeIgniter\Model;

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
