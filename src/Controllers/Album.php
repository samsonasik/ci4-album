<?php namespace Album\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use Album\Domain\Album\AlbumRepository;
use Album\Domain\Exception\RecordNotFoundException;
use Album\Models\AlbumModel;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class Album extends BaseController
{
	/** @var IncomingRequest */
	protected $request;

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
		$data['pager']   = model(AlbumModel::class)->pager;

		return view('Album\Views\album\index', $data);
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

			session()->setFlashdata('errors', model(AlbumModel::class)->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\album\add', ['errors' => session()->getFlashData('errors')]);
	}

	public function edit(int $id)
	{
		try
		{
			$album = $this->repository->findAlbumOfId($id);
		}
		catch (RecordNotFoundException $e)
		{
			throw PageNotFoundException::forPageNotFound($e->getMessage());
		}

		if ($this->request->getMethod() === 'post')
		{
			$data = $this->request->getPost();
			if ($this->repository->save($data))
			{
				session()->setFlashdata('status', 'Album has been updated');
				return redirect()->route('album-index');
			}

			session()->setFlashdata('errors', model(AlbumModel::class)->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\album\edit', ['album' => $album, 'errors' => session()->getFlashData('errors')]);
	}

	public function delete(int $id)
	{
		try
		{
			$this->repository->deleteOfId($id);
		}
		catch (RecordNotFoundException $e)
		{
			throw PageNotFoundException::forPageNotFound($e->getMessage());
		}

		session()->setFlashdata('status', 'Album has been deleted');
		return redirect()->route('album-index');
	}
}
