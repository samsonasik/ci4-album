<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace AlbumTest\Unit\Domain\Album;

use Album\Domain\Album\AlbumNotFoundException;
use Error;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AlbumNotFoundExceptionTest extends TestCase
{
    public function testCannotInstantiateDirectly(): void
    {
        $this->expectException(Error::class);
        new AlbumNotFoundException('message');
    }

    public function testInstantiateforAlbumDoesnotExistOfId(): void
    {
        $this->assertInstanceOf(
            AlbumNotFoundException::class,
            AlbumNotFoundException::forAlbumDoesnotExistOfId(1)
        );
    }
}
