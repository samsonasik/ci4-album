<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Infrastructure\Persistence;

use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Model;

/**
 * @internal
 *
 * @property Model $model
 */
trait DMLPersistence
{
    public function save(?array $data = null): bool
    {
        try {
            return $this->model->save(new $this->model->returnType($data));
        } catch (DataException $e) {
            return false;
        }
    }
}
