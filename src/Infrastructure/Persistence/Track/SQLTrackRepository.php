<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Infrastructure\Persistence\Track;

use Album\Config\Album as ConfigAlbum;
use Album\Domain\Album\Album;
use Album\Domain\Track\Track;
use Album\Domain\Track\TrackDuplicatedRectorException;
use Album\Domain\Track\TrackNotFoundException;
use Album\Domain\Track\TrackRepository;
use Album\Infrastructure\Persistence\DMLPersistence;
use Album\Models\TrackModel;
use Config\Services;

final class SQLTrackRepository implements TrackRepository
{
    use DMLPersistence {
        save as saveData;
    }

    public function __construct(private readonly TrackModel $model)
    {
    }

    public function findPaginatedData(Album $album, string $keyword = ''): ?array
    {
        $this->model
            ->builder()
            ->where('album_id', $album->id);

        if ($keyword !== '') {
            $this->model
                ->builder()
                ->groupStart()
                ->like('title', $keyword)
                ->orLike('author', $keyword)
                ->groupEnd();
        }

        /** @var ConfigAlbum $album */
        $album = config('Album');

        return $this->model->paginate($album->paginationPerPage);
    }

    public function findTrackOfId(int $id): Track
    {
        $track = $this->model->find($id);
        if (! $track instanceof Track) {
            throw TrackNotFoundException::forAlbumTrackDoesnotExistOfId($id);
        }

        return $track;
    }

    public function deleteOfId(int $id): bool
    {
        $this->model->delete($id);
        if ($this->model->db->affectedRows() === 0) {
            throw TrackNotFoundException::forAlbumTrackDoesnotExistOfId($id);
        }

        return true;
    }

    public function save(?array $data = null): bool
    {
        // model->validate() check empty data early to run true
        // which on controller test with invalid data, it bypassed
        // so need to instantiate validation service with set rules here
        $validation = Services::validation(null, false);
        $isValid    = $validation->setRules($this->model->getValidationRules())
            ->run($data);

        if (! $isValid) {
            return false;
        }

        if (isset($data['id'])) {
            /** @var array{id: int, title: string, album_id:int} $data */
            $this->model
                ->builder()
                ->where('id !=', $data['id'])
                ->where('title', $data['title'])
                ->where('album_id', $data['album_id']);

            $result = $this->model->get()->getResult();
            if ($result === []) {
                return $this->saveData($data);
            }

            throw TrackDuplicatedRectorException::forDuplicatedTitle($data['album_id']);
        }

        /** @var array{title: string, album_id:int} $data */
        $this->model
            ->builder()
            ->where('album_id', $data['album_id'])
            ->where('title', $data['title']);

        $result = $this->model->get()->getResult();
        if ($result !== []) {
            throw TrackDuplicatedRectorException::forDuplicatedTitle($data['album_id']);
        }

        return $this->saveData($data);
    }
}
