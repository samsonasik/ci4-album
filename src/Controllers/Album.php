<?php namespace Album\Controllers;

use Album\Models\AlbumModel;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Album extends BaseController
{
	/** @var AlbumModel */
	private $model;

	public function __construct()
	{
		$this->model = model(AlbumModel::class);
	}

	public function index()
	{
		$keyword = $this->request->getGet('keyword') ?? '';
		$data    = $this->model->getPaginatedData($keyword);

		return view('Album\Views\index', $data);
	}

	public function add()
	{
		if ($this->request->getMethod() === 'post')
		{
			$data = $this->request->getPost();
			if ($this->model->save(new $this->model->returnType($data)))
			{
				session()->setFlashdata('status', 'New album has been added');
				return redirect()->route('album-index');
			}

			session()->setFlashdata('errors', $this->model->errors());
			return redirect()->withInput()->back();
		}

		return view('Album\Views\add', ['errors' => session()->getFlashData('errors')]);
	}

	public function edit(int $id)
	{
		$album = $this->model->find($id);
		if ($album instanceof $this->model->returnType)
		{
			if ($this->request->getMethod() === 'post')
			{
				$data = $this->request->getPost();
				if ($this->model->save(new $this->model->returnType($data)))
				{
					session()->setFlashdata('status', 'Album has been updated');
					return redirect()->route('album-index');
				}

				session()->setFlashdata('errors', $this->model->errors());
				return redirect()->withInput()->back();
			}

			return view('Album\Views\edit', ['album' => $album, 'errors' => session()->getFlashData('errors')]);
		}

		throw new PageNotFoundException();
	}

	public function delete(int $id)
	{
		$delete = $this->model->delete($id);
		if ($delete->connID->affected_rows === 1)
		{
			session()->setFlashdata('status', 'Album has been deleted');
			return redirect()->route('album-index');
		}

		throw new PageNotFoundException();
	}
}
