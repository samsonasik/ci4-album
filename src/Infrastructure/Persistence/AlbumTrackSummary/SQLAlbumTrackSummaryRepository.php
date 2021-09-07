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

use Album\Domain\AlbumTrackSummary\AlbumTrackSummary;
use Album\Domain\AlbumTrackSummary\AlbumTrackSummaryRepository;
use Album\Models\AlbumModel;
use Album\Models\TrackModel;

final class SQLAlbumTrackSummaryRepository implements AlbumTrackSummaryRepository
{
    /**
     * @var AlbumModel
     */
    private $albumModel;

    /**
     * @var TrackModel
     */
    private $trackModel;

    public function __construct(AlbumModel $albumModel, TrackModel $trackModel)
    {
        $this->albumModel = $albumModel;
        $this->trackModel = $trackModel;
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

        return $this->albumModel
            ->paginate(config('Album')->paginationPerPage);
    }
}
