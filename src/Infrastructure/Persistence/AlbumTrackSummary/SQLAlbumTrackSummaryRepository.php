<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Infrastructure\Persistence\AlbumTrackSummary;

use Album\Config\Album;
use Album\Domain\AlbumTrackSummary\AlbumTrackSummary;
use Album\Domain\AlbumTrackSummary\AlbumTrackSummaryRepository;
use Album\Models\AlbumModel;
use Album\Models\TrackModel;

final class SQLAlbumTrackSummaryRepository implements AlbumTrackSummaryRepository
{
    public function __construct(private AlbumModel $albumModel, private TrackModel $trackModel)
    {
    }

    public function findPaginatedSummaryTotalSongData(): ?array
    {
        $this->albumModel->builder()
            ->select([
                '*',
                '(' . $this->trackModel
                    ->builder()
                    ->select('count(*)')
                    ->where('album_id = album.id')
                    ->getCompiledSelect() .
                 ') AS total_song',
            ]);
        $this->albumModel->asObject(AlbumTrackSummary::class);

        /** @var Album $album */
        $album = config('Album');

        return $this->albumModel
            ->paginate($album->paginationPerPage);
    }
}
