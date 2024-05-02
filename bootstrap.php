<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use App\Controllers\BaseController;

require __DIR__ . '/vendor/codeigniter4/framework/system/Test/bootstrap.php';

// with this check, the class is loaded
class_exists(BaseController::class);
