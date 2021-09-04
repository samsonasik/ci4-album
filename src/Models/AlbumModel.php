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

use Album\Domain\Album\Album;
use CodeIgniter\Database\MySQLi\Connection;
use CodeIgniter\Model;

/**
 * @property Connection $db
 */
class AlbumModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'album';
    /**
     * @var string
     */
    protected $returnType = Album::class;
    /**
     * @var string[]
     */
    protected $allowedFields = [
        'artist',
        'title',
    ];
    /**
     * @var array<string, string>
     */
    protected $validationRules = [
        'artist' => 'required|alpha_numeric_space|min_length[3]|max_length[255]',
        'title'  => 'required|alpha_numeric_space|min_length[3]|max_length[255]|is_unique[album.title,id,{id}]',
    ];
}
