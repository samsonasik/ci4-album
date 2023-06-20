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

use Album\Domain\Exception\DuplicatedRecordException;

final class TrackDuplicatedRectorException extends DuplicatedRecordException
{
    public static function forDuplicatedTitle(int $id): self
    {
        return new self(sprintf(
            'The track with album id %d has duplicated title.',
            $id
        ));
    }
}
