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
		$albumTable = $this->albumModel->table;
		$trackTable = $this->trackModel->table;

		$this->albumModel->builder()
						 ->select([
							 sprintf('%s.*', $albumTable),
							 sprintf('COUNT(%s.id) as total_song', $trackTable),
						 ])
						->join($trackTable, sprintf('%s.id = %s.album_id', $albumTable, $trackTable), 'LEFT')
						->groupBy(sprintf('%s.id', $albumTable));

		return $this->albumModel->asObject(AlbumTrackSummary::class)->paginate(config('Album')->paginationPerPage);
	}
}
