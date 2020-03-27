<?php namespace Album\Controllers;

use Album\Domain\Album\AlbumRepository;
use Album\Domain\Exception\RecordNotFoundException;
use Album\Domain\Track\TrackRepository;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
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
		try
		{
			$album = $this->albumRepository->findAlbumOfId($albumId);
		}
		catch (RecordNotFoundException $e)
		{
			throw new PageNotFoundException($e->getMessage());
		}

		$data['keyword'] = $this->request->getGet('keyword') ?? '';
		$data['tracks']  = $this->trackRepository->findPaginatedData($album, $data['keyword']);
		$data['pager']   = $this->trackRepository->pager();

		return view('Album\Views\track\index', $data);
	}

	public function add(int $albumId)
	{
		try
		{
			$album = $this->albumRepository->findAlbumOfId($albumId);
		}
		catch (RecordNotFoundException $e)
		{
			throw new PageNotFoundException($e->getMessage());
		}

		if ($this->request->getMethod() === 'post')
		{
			$data = $this->request->getPost();
			if ($this->trackRepository->save($data))
			{
				session()->setFlashdata('status', 'New album track has been added');
				return redirect()->route('track-index', [$albumId]);
			}

			session()->setFlashdata('errors', $this->trackRepository->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\track\add', ['albumId' => $album->id, 'errors' => session()->getFlashData('errors')]);
	}

	public function edit(int $albumId, int $trackId)
	{
		try
		{
			$this->albumRepository->findAlbumOfId($albumId);
			$track = $this->trackRepository->findTrackOfId($trackId);
		}
		catch (RecordNotFoundException $e)
		{
			throw new PageNotFoundException($e->getMessage());
		}

		if ($this->request->getMethod() === 'post')
		{
			$data = $this->request->getPost();
			if ($this->trackRepository->save($data))
			{
				session()->setFlashdata('status', 'Album track has been updated');
				return redirect()->route('track-index', [$albumId]);
			}

			session()->setFlashdata('errors', $this->trackRepository->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\track\edit', ['track' => $track, 'errors' => session()->getFlashData('errors')]);
	}

	public function delete(int $albumId, int $trackId)
	{
		try
		{
			$this->albumRepository->findAlbumOfId($albumId);
			$this->trackRepository->deleteOfId($trackId);
		}
		catch (RecordNotFoundException $e)
		{
			throw new PageNotFoundException($e->getMessage());
		}

		session()->setFlashdata('status', 'Album track has been deleted');
		return redirect()->route('track-index', [$albumId]);
	}
}
