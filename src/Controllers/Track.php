<?php namespace Album\Controllers;

use Album\Domain\Exception\RecordNotFoundException;
use Album\Domain\Track\TrackRepository;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class Track extends BaseController
{
	/** @var TrackRepository */
	private $repository;

	public function __construct()
	{
		$this->repository = Services::trackRepository();
	}

	public function index(int $albumId)
	{
		$data['keyword'] = $this->request->getGet('keyword') ?? '';
		$data['tracks']  = $this->repository->findPaginatedData($albumId, $data['keyword']);
		$data['pager']   = $this->repository->pager();

		return view('Album\Views\track\index', $data);
	}

	public function add(int $albumId)
	{
		if ($this->request->getMethod() === 'post')
		{
			$data = $this->request->getPost();
			if ($this->repository->save($data))
			{
				session()->setFlashdata('status', 'New album track has been added');
				return redirect()->route('track-index');
			}

			session()->setFlashdata('errors', $this->repository->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\track\add', ['albumId' => $albumId, 'errors' => session()->getFlashData('errors')]);
	}

	public function edit(int $trackId)
	{
		try
		{
			$track = $this->repository->findTrackOfId($trackId);
		}
		catch (RecordNotFoundException $e)
		{
			throw new PageNotFoundException($e->getMessage());
		}

		if ($this->request->getMethod() === 'post')
		{
			$data = $this->request->getPost();
			if ($this->repository->save($data))
			{
				session()->setFlashdata('status', 'Album track has been updated');
				return redirect()->route('track-index');
			}

			session()->setFlashdata('errors', $this->repository->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\track\edit', ['track' => $track, 'errors' => session()->getFlashData('errors')]);
	}

	public function delete(int $trackId)
	{
		try
		{
			$this->repository->deleteOfId($trackId);
		}
		catch (RecordNotFoundException $e)
		{
			throw new PageNotFoundException($e->getMessage());
		}

		session()->setFlashdata('status', 'Album track has been deleted');
		return redirect()->route('track-index');
	}
}
