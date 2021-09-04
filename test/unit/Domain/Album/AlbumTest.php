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

use Album\Domain\Album\Album;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AlbumTest extends TestCase
{
    public function testFillGetAttributes(): void
    {
        $entity = new Album([
            'id'     => 1,
            'artist' => 'sheila on 7',
            'title'  => 'kisah klasik untuk masa depan',
        ]);

        $this->assertSame(1, $entity->id);
        $this->assertSame('Sheila On 7', $entity->artist);
        $this->assertSame('Kisah Klasik Untuk Masa Depan', $entity->title);
    }
}
