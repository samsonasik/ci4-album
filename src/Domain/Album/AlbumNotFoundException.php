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

use Album\Domain\Exception\RecordNotFoundException;

final class AlbumNotFoundException extends RecordNotFoundException
{
    public static function forAlbumDoesnotExistOfId(int $id): self
    {
        return new self(sprintf(
            'The album with album ID %d you requested does not exist.',
            $id
        ));
    }
}
