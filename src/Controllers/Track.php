<?php namespace Album\Controllers;

use Album\Domain\Album\AlbumRepository;
use Album\Domain\Track\TrackRepository;
use Album\Models\TrackModel;
use App\Controllers\BaseController;
use Config\Services;

class Track extends BaseController
{
	/** @var AlbumRepository */
	private $albumRepository;

	/** @var TrackRepository */
	private $trackRepository;

	public function __construct()
	{
		$this->albumRepository = Services::albumRepository();
		$this->trackRepository = Services::trackRepository();
	}

	public function index(int $albumId)
	{
		$album = $this->albumRepository->findAlbumOfId($albumId);

		$data['keyword'] = $this->request->getGet('keyword') ?? '';
		$data['album']   = $album;
		$data['tracks']  = $this->trackRepository->findPaginatedData($album, $data['keyword']);
		$data['pager']   = model(TrackModel::class)->pager;

		return view('Album\Views\track\index', $data);
	}

	public function add(int $albumId)
	{
		$album = $this->albumRepository->findAlbumOfId($albumId);

		if ($this->request->getMethod() === 'post')
		{
			$data = $this->request->getPost();
			if ($this->trackRepository->save($data))
			{
				session()->setFlashdata('status', 'New album track has been added');
				return redirect()->route('track-index', [$albumId]);
			}

			session()->setFlashdata('errors', model(TrackModel::class)->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\track\add', [
			'album'  => $album,
			'errors' => session()->getFlashData('errors'),
		]);
	}

	public function edit(int $albumId, int $trackId)
	{
		$album = $this->albumRepository->findAlbumOfId($albumId);
		$track = $this->trackRepository->findTrackOfId($trackId);

		if ($this->request->getMethod() === 'post')
		{
			$data = $this->request->getPost();
			if ($this->trackRepository->save($data))
			{
				session()->setFlashdata('status', 'Album track has been updated');
				return redirect()->route('track-index', [$albumId]);
			}

			session()->setFlashdata('errors', model(TrackModel::class)->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\track\edit', [
			'album'  => $album,
			'track'  => $track,
			'errors' => session()->getFlashData('errors'),
		]);
	}

	public function delete(int $albumId, int $trackId)
	{
		$this->albumRepository->findAlbumOfId($albumId);
		$this->trackRepository->deleteOfId($trackId);

		session()->setFlashdata('status', 'Album track has been deleted');
		return redirect()->route('track-index', [$albumId]);
	}
}
