<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Domain\Track;

use Album\Domain\Album\Album;
use Album\Domain\DMLRepository;

interface TrackRepository extends DMLRepository
{
    public function findPaginatedData(Album $album, string $keyword = ''): ?array;

    public function findTrackOfId(int $id): Track;
}
