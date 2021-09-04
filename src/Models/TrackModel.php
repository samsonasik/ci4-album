<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Models;

use Album\Domain\Track\Track;
use CodeIgniter\Database\MySQLi\Connection;
use CodeIgniter\Model;

/**
 * @property Connection $db
 */
class TrackModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'track';

    /**
     * @var string
     */
    protected $returnType = Track::class;

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'album_id',
        'title',
        'author',
    ];

    /**
     * @var array<string, string>
     */
    protected $validationRules = [
        'album_id' => 'required|numeric',
        'title'    => 'required|alpha_numeric_space|min_length[3]|max_length[255]|is_unique[track.title,id,{id}]',
        'author'   => 'required|alpha_numeric_space|min_length[3]|max_length[255]',
    ];
}
