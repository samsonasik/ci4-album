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

use Album\Domain\Exception\RecordNotFoundException;

class TrackNotFoundException extends RecordNotFoundException
{
    final public static function forAlbumTrackDoesnotExistOfId(int $id): self
    {
        return new self(sprintf(
            'The album track with track ID %d you requested does not exist.',
            $id
        ));
    }
}
