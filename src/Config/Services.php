<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Config;

use Album\Infrastructure\Persistence\Album\SQLAlbumRepository;
use Album\Infrastructure\Persistence\AlbumTrackSummary\SQLAlbumTrackSummaryRepository;
use Album\Infrastructure\Persistence\Track\SQLTrackRepository;
use Album\Models\AlbumModel;
use Album\Models\TrackModel;
use CodeIgniter\Config\BaseService;

final class Services extends BaseService
{
    public static function albumRepository(bool $getShared = true): SQLAlbumRepository
    {
        if ($getShared) {
            return static::getSharedInstance('albumRepository');
        }

        return new SQLAlbumRepository(model(AlbumModel::class));
    }

    public static function trackRepository(bool $getShared = true): SQLTrackRepository
    {
        if ($getShared) {
            return static::getSharedInstance('trackRepository');
        }

        return new SQLTrackRepository(model(TrackModel::class));
    }

    public static function albumTrackSummary(bool $getShared = true): SQLAlbumTrackSummaryRepository
    {
        if ($getShared) {
            return static::getSharedInstance('albumTrackSummary');
        }

        return new SQLAlbumTrackSummaryRepository(
            model(AlbumModel::class),
            model(TrackModel::class)
        );
    }
}
