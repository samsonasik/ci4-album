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

final class Track extends BaseController
{
    /**
     * @var string
     */
    private const KEYWORD = 'keyword';

    /**
     * @var string
     */
    private const ALBUM = 'album';

    /**
     * @var string
     */
    private const STATUS = 'status';

    /**
     * @var string
     */
    private const TRACK_INDEX = 'track-index';

    /**
     * @var string
     */
    private const ERRORS = 'errors';

    /**
     * @var IncomingRequest
     */
    protected $request;

    private readonly AlbumRepository $albumRepository;
    private readonly TrackRepository $trackRepository;

    public function __construct()
    {
        $this->albumRepository = Services::albumRepository();
        $this->trackRepository = Services::trackRepository();
    }

    public function index(int $albumId): string
    {
        $data = [];

        try {
            $album = $this->albumRepository->findAlbumOfId($albumId);
        } catch (RecordNotFoundException $recordNotFoundException) {
            throw PageNotFoundException::forPageNotFound($recordNotFoundException->getMessage());
        }

        /** @var string $keyword */
        $keyword             = $this->request->getGet(self::KEYWORD) ?? '';
        $data[self::KEYWORD] = $keyword;
        $data[self::ALBUM]   = $album;
        $data['tracks']      = $this->trackRepository->findPaginatedData($album, $keyword);
        $data['pager']       = model(TrackModel::class)->pager;

        return view('Album\Views\track\index', $data);
    }

    public function add(int $albumId): RedirectResponse|string
    {
        try {
            $album = $this->albumRepository->findAlbumOfId($albumId);
        } catch (RecordNotFoundException $recordNotFoundException) {
            throw PageNotFoundException::forPageNotFound($recordNotFoundException->getMessage());
        }

        if ($this->request->getMethod() === 'post') {
            /** @var array $data */
            $data = $this->request->getPost();
            if ($this->trackRepository->save($data)) {
                session()->setFlashdata(self::STATUS, 'New album track has been added');

                return redirect()->route(self::TRACK_INDEX, [$albumId]);
            }

            session()->setFlashdata(self::ERRORS, model(TrackModel::class)->errors());

            return redirect()->withInput()->back();
        }

        return view('Album\Views\track\add', [
            self::ALBUM  => $album,
            self::ERRORS => session()->getFlashData(self::ERRORS),
        ]);
    }

    public function edit(int $albumId, int $trackId): RedirectResponse|string
    {
        try {
            $album = $this->albumRepository->findAlbumOfId($albumId);
            $track = $this->trackRepository->findTrackOfId($trackId);
        } catch (RecordNotFoundException $recordNotFoundException) {
            throw PageNotFoundException::forPageNotFound($recordNotFoundException->getMessage());
        }

        if ($this->request->getMethod() === 'post') {
            /** @var array $data */
            $data = $this->request->getPost();
            if ($this->trackRepository->save($data)) {
                session()->setFlashdata(self::STATUS, 'Album track has been updated');

                return redirect()->route(self::TRACK_INDEX, [$albumId]);
            }

            session()->setFlashdata(self::ERRORS, model(TrackModel::class)->errors());

            return redirect()->withInput()->back();
        }

        return view('Album\Views\track\edit', [
            self::ALBUM  => $album,
            'track'      => $track,
            self::ERRORS => session()->getFlashData(self::ERRORS),
        ]);
    }

    public function delete(int $albumId, int $trackId): RedirectResponse
    {
        try {
            $this->albumRepository->findAlbumOfId($albumId);
            $this->trackRepository->deleteOfId($trackId);
        } catch (RecordNotFoundException $recordNotFoundException) {
            throw PageNotFoundException::forPageNotFound($recordNotFoundException->getMessage());
        }

        session()->setFlashdata(self::STATUS, 'Album track has been deleted');

        return redirect()->route(self::TRACK_INDEX, [$albumId]);
    }
}
