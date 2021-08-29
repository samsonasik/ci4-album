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

use CodeIgniter\Entity\Entity;

/**
 * @property string $artist
 * @property int    $id
 * @property string $title
 */
class Album extends Entity
{
    protected $attributes = [
        'id'     => null,
        'artist' => null,
        'title'  => null,
    ];

    public function setArtist(string $artist): void
    {
        $this->attributes['artist'] = ucwords($artist);
    }

    public function setTitle(string $title): void
    {
        $this->attributes['title'] = ucwords($title);
    }
}
