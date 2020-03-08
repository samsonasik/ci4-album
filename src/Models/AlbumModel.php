<?php namespace Album\Models;

use Album\Entities\Album;
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
		'artist' => 'required|alpha_numeric_space|min_length[3]max_length[255]',
		'title'  => 'required|alpha_numeric_space|min_length[3]|max_length[255]',
	];

	public function getPaginatedData(string $keyword = ''): array
	{
		if ($keyword)
		{
			$this->builder()
				 ->groupStart()
					 ->like('artist', $keyword)
					 ->orLike('title', $keyword)
				 ->groupEnd();
		}

		return [
			'albums'  => $this->paginate(config('Album')->paginationPerPage ?? 10),
			'pager'   => $this->pager,
			'keyword' => $keyword,
		];
	}
}
