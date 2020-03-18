<?php namespace Album\Controllers;

use Album\Domain\Album\AlbumRepository;
use Album\Domain\Exception\RecordNotFoundException;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class Album extends BaseController
{
	/** @var AlbumRepository */
	private $repository;

	public function __construct()
	{
		$this->repository = Services::albumRepository();
	}

	public function index()
	{
		$data['keyword'] = $this->request->getGet('keyword') ?? '';
		$data['albums']  = $this->repository->findPaginatedData($data['keyword']);
		$data['pager']   = $this->repository->pager();

		return view('Album\Views\index', $data);
	}

	public function add()
	{
		if ($this->request->getMethod() === 'post')
		{
			$data = $this->request->getPost();
			if ($this->repository->save($data))
			{
				session()->setFlashdata('status', 'New album has been added');
				return redirect()->route('album-index');
			}

			session()->setFlashdata('errors', $this->repository->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\add', ['errors' => session()->getFlashData('errors')]);
	}

	public function edit(int $id)
	{
		try
		{
			$album = $this->repository->findAlbumOfId($id);
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
				session()->setFlashdata('status', 'Album has been updated');
				return redirect()->route('album-index');
			}

			session()->setFlashdata('errors', $this->repository->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\edit', ['album' => $album, 'errors' => session()->getFlashData('errors')]);
	}

	public function delete(int $id)
	{
		try
		{
			$this->repository->deleteOfId($id);
		}
		catch (RecordNotFoundException $e)
		{
			throw new PageNotFoundException($e->getMessage());
		}

		session()->setFlashdata('status', 'Album has been deleted');
		return redirect()->route('album-index');
	}
}
