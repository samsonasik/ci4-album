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
use Album\Domain\Track\TrackRepository;
use Album\Models\TrackModel;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class Track extends BaseController
{
    /**
     * @var IncomingRequest
     */
    protected $request;

    /**
     * @var AlbumRepository
     */
    private $albumRepository;

    /**
     * @var TrackRepository
     */
    private $trackRepository;

    public function __construct()
    {
        $this->albumRepository = Services::albumRepository();
        $this->trackRepository = Services::trackRepository();
    }

    public function index(int $albumId): string
    {
        try {
            $album = $this->albumRepository->findAlbumOfId($albumId);
        } catch (RecordNotFoundException $e) {
            throw PageNotFoundException::forPageNotFound($e->getMessage());
        }

        $data['keyword'] = $this->request->getGet('keyword') ?? '';
        $data['album']   = $album;
        $data['tracks']  = $this->trackRepository->findPaginatedData($album, $data['keyword']);
        $data['pager']   = model(TrackModel::class)->pager;

        return view('Album\Views\track\index', $data);
    }

    /**
     * @return RedirectResponse|string
     */
    public function add(int $albumId)
    {
        try {
            $album = $this->albumRepository->findAlbumOfId($albumId);
        } catch (RecordNotFoundException $e) {
            throw PageNotFoundException::forPageNotFound($e->getMessage());
        }

        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            if ($this->trackRepository->save($data)) {
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

    /**
     * @return RedirectResponse|string
     */
    public function edit(int $albumId, int $trackId)
    {
        try {
            $album = $this->albumRepository->findAlbumOfId($albumId);
            $track = $this->trackRepository->findTrackOfId($trackId);
        } catch (RecordNotFoundException $e) {
            throw PageNotFoundException::forPageNotFound($e->getMessage());
        }

        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            if ($this->trackRepository->save($data)) {
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

    public function delete(int $albumId, int $trackId): RedirectResponse
    {
        try {
            $this->albumRepository->findAlbumOfId($albumId);
            $this->trackRepository->deleteOfId($trackId);
        } catch (RecordNotFoundException $e) {
            throw PageNotFoundException::forPageNotFound($e->getMessage());
        }

        session()->setFlashdata('status', 'Album track has been deleted');

        return redirect()->route('track-index', [$albumId]);
    }
}
