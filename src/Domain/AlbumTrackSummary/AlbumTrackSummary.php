<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Domain\AlbumTrackSummary;

use CodeIgniter\Entity\Entity;

/**
 * @property int    $artist
 * @property int    $id
 * @property string $title
 * @property string $total_song
 */
class AlbumTrackSummary extends Entity
{
    protected $attributes = [
        'id'         => null,
        'artist'     => null,
        'title'      => null,
        'total_song' => null,
    ];
}
