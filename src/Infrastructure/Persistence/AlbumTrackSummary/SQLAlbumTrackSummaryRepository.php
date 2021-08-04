<?php namespace Album\Infrastructure\Persistence\AlbumTrackSummary;

use Album\Domain\AlbumTrackSummary\AlbumTrackSummary;
use Album\Domain\AlbumTrackSummary\AlbumTrackSummaryRepository;
use Album\Models\AlbumModel;
use Album\Models\TrackModel;

class SQLAlbumTrackSummaryRepository implements AlbumTrackSummaryRepository
{
	/** @var AlbumModel */
	private $albumModel;

	/** @var TrackModel */
	private $trackModel;

	public function __construct(AlbumModel $albumModel, TrackModel $trackModel)
	{
		$this->albumModel = $albumModel;
		$this->trackModel = $trackModel;
	}

	public function findPaginatedSummaryTotalSongData(): ?array
	{
		$this->albumModel->builder()
						 ->select([
							 '*',
							 '(' . $this->trackModel
								  ->builder()
								  ->select('count(*)')
								  ->where('album_id = album.id')
								  ->getCompiledSelect() .
							  ') AS total_song',
						 ]);
		$this->albumModel->asObject(AlbumTrackSummary::class);
		return $this->albumModel
					->paginate(config('Album')->paginationPerPage);
	}
}
