<?php namespace Album\Controllers;

use Album\Models\AlbumModel;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Album extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = model(AlbumModel::class);
	}

	public function index()
	{
		helper('form');

		$keyword = $this->request->getGet('keyword') ?? '';
		$data    = $this->model->getPaginatedData($keyword);

		return view('Album\Views\index', $data);
	}

	public function add()
	{
		helper('form');

		if ($this->request->getMethod() === 'post')
		{
			$data = $this->request->getPost();
			$data['artist'] = $data['artist'] ?? '';
			$data['title'] = $data['title'] ?? '';

			if ($this->model->save(new $this->model->returnType($data)))
			{
				$session = session();
				$session->setFlashdata('status', 'New album has been added');

				return redirect()->to(base_url('album'));
			}

			$errors = $this->model->errors();
		}

		return view('Album\Views\add', ['errors' => $errors ?? []]);
	}

	public function edit(int $id)
	{
		helper('form');

		$album = $this->model->find($id);
		if ($album instanceof $this->model->returnType)
		{
			if ($this->request->getMethod() === 'post')
			{
				$data = $this->request->getPost();
				$data['id']     = $data['id'] ?? '';
				$data['artist'] = $data['artist'] ?? '';
				$data['title']  = $data['title'] ?? '';

				if ($this->model->save(new $this->model->returnType($data)))
				{
					$session = session();
					$session->setFlashdata('status', 'Album has been updated');

					return redirect()->to(base_url('album'));
				}

				$errors = $this->model->errors();
			}

			return view('Album\Views\edit', ['album' => $album, 'errors' => $errors ?? []]);
		}

		throw new PageNotFoundException();
	}

	public function delete(int $id)
	{
		$delete = $this->model->delete($id);
		if ($delete->connID->affected_rows === 1)
		{
			$session = session();
			$session->setFlashdata('status', 'Album has been deleted');

			return redirect()->to(base_url('album'));
		}

		throw new PageNotFoundException();
	}
}
