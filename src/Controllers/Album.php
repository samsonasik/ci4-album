<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Controllers;

use Album\Domain\Album\AlbumRepository;
use Album\Domain\Exception\RecordNotFoundException;
use Album\Models\AlbumModel;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

final class Album extends BaseController
{
    /**
     * @var string
     */
    private const KEYWORD = 'keyword';

    /**
     * @var string
     */
    private const STATUS = 'status';

    /**
     * @var string
     */
    private const ALBUM_INDEX = 'album-index';

    /**
     * @var string
     */
    private const ERRORS = 'errors';

    /**
     * @var IncomingRequest
     */
    protected $request;

    /**
     * @var AlbumRepository
     */
    private $albumRepository;

    public function __construct()
    {
        $this->albumRepository = Services::albumRepository();
    }

    public function index(): string
    {
        $data = [];
        /** @var string $keyword */
        $keyword             = $this->request->getGet(self::KEYWORD) ?? '';
        $data[self::KEYWORD] = $keyword;
        $data['albums']      = $this->albumRepository->findPaginatedData($keyword);
        $data['pager']       = model(AlbumModel::class)->pager;

        return view('Album\Views\album\index', $data);
    }

    /**
     * @return RedirectResponse|string
     */
    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            /** @var array $data */
            $data = $this->request->getPost();
            if ($this->albumRepository->save($data)) {
                session()->setFlashdata(self::STATUS, 'New album has been added');

                return redirect()->route(self::ALBUM_INDEX);
            }

            session()->setFlashdata(self::ERRORS, model(AlbumModel::class)->errors());

            return redirect()->withInput()->back();
        }

        return view('Album\Views\album\add', [self::ERRORS => session()->getFlashData(self::ERRORS)]);
    }

    /**
     * @return RedirectResponse|string
     */
    public function edit(int $id)
    {
        try {
            $album = $this->albumRepository->findAlbumOfId($id);
        } catch (RecordNotFoundException $recordNotFoundException) {
            throw PageNotFoundException::forPageNotFound($recordNotFoundException->getMessage());
        }

        if ($this->request->getMethod() === 'post') {
            /** @var array $data */
            $data = $this->request->getPost();
            if ($this->albumRepository->save($data)) {
                session()->setFlashdata(self::STATUS, 'Album has been updated');

                return redirect()->route(self::ALBUM_INDEX);
            }

            session()->setFlashdata(self::ERRORS, model(AlbumModel::class)->errors());

            return redirect()->withInput()->back();
        }

        return view('Album\Views\album\edit', ['album' => $album, self::ERRORS => session()->getFlashData(self::ERRORS)]);
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            $this->albumRepository->deleteOfId($id);
        } catch (RecordNotFoundException $recordNotFoundException) {
            throw PageNotFoundException::forPageNotFound($recordNotFoundException->getMessage());
        }

        session()->setFlashdata(self::STATUS, 'Album has been deleted');

        return redirect()->route(self::ALBUM_INDEX);
    }
}
