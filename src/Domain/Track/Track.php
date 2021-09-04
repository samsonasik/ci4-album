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

use CodeIgniter\Entity\Entity;

/**
 * @property int    $album_id
 * @property string $author
 * @property int    $id
 * @property string $title
 */
class Track extends Entity
{
    /**
     * @var array<string, null>|string[]
     */
    protected $attributes = [
        'id'       => null,
        'album_id' => null,
        'title'    => null,
        'author'   => null,
    ];

    public function setTitle(string $title): void
    {
        $this->attributes['title'] = ucwords($title);
    }

    public function setAuthor(string $author): void
    {
        $this->attributes['author'] = ucwords($author);
    }
}
