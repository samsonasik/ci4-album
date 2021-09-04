<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace AlbumTest\Unit\Domain\Track;

use Album\Domain\Track\TrackNotFoundException;
use Error;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class TrackNotFoundExceptionTest extends TestCase
{
    public function testCannotInstantiateDirectly(): void
    {
        $this->expectException(Error::class);
        new TrackNotFoundException('message');
    }

    public function testInstantiateforAlbumTrackDoesnotExistOfId(): void
    {
        $this->assertInstanceOf(
            TrackNotFoundException::class,
            TrackNotFoundException::forAlbumTrackDoesnotExistOfId(1)
        );
    }
}
