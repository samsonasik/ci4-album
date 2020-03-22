<?php namespace Album\Infrastructure\Persistence\Track;

use Album\Domain\Album\Album;
use Album\Domain\Track\Track;
use Album\Domain\Track\TrackNotFoundException;
use Album\Domain\Track\TrackRepository;
use Album\Models\TrackModel;
use CodeIgniter\Pager\PagerInterface;

class SQLTrackRepository implements TrackRepository
{
	private $model;

	public function __construct(TrackModel $model)
	{
		$this->model = $model;
	}

	public function findPaginatedData(Album $album, string $keyword = ''): ?array
	{
		if ($keyword)
		{
			$this->model
				 ->builder()
				 ->where('album_id', $album->id)
				 ->groupStart()
					 ->like('artist', $keyword)
					 ->orLike('title', $keyword)
				 ->groupEnd();
		}

		return $this->model->paginate(config('Album')->paginationPerPage);
	}

	public function pager(): ?PagerInterface
	{
		return $this->model->pager;
	}

	public function findTrackOfId(int $id): Track
	{
		$track = $this->model->find($id);
		if (! $track instanceof Track)
		{
			throw new TrackNotFoundException();
		}

		return $track;
	}

	public function save(array $data = null): bool
	{
		return $this->model->save(new $this->model->returnType($data));
	}

	public function errors(): ?array
	{
		return $this->model->errors();
	}

	public function deleteOfId(int $id) : bool
	{
		$delete = $this->model->delete($id);
		if ($delete->connID->affected_rows === 0)
		{
			throw new TrackNotFoundException();
		}

		return true;
	}
}
