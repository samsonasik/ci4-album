<?php namespace Album\Controllers;

use Album\Domain\AlbumTrackSummary\AlbumTrackSummaryRepository;
use Album\Models\AlbumModel;
use App\Controllers\BaseController;
use Config\Services;

class AlbumTrackSummary extends BaseController
{
	/** @var AlbumTrackSummaryRepository */
	private $repository;

	public function __construct()
	{
		$this->repository = Services::albumTrackSummary();
	}

	public function totalsong()
	{
		$data['summary'] = $this->repository->getPaginatedSummaryAlbumTrackTotalSong();
		$data['pager']   = model(AlbumModel::class)->pager;

		return view('Album\Views\album-track-summary\totalsong', $data);
	}
}
