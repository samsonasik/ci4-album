<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Domain\Album;

use Album\Domain\DMLRepository;

interface AlbumRepository extends DMLRepository
{
    public function findPaginatedData(string $keyword = ''): ?array;

    public function findAlbumOfId(int $id): Album;
}
