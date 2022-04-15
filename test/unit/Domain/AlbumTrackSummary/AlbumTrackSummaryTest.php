<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace AlbumTest\Unit\Domain\AlbumTrackSummary;

use Album\Domain\AlbumTrackSummary\AlbumTrackSummary;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AlbumTrackSummaryTest extends TestCase
{
    public function testFillGetAttributes(): void
    {
        $albumTrackSummary = new AlbumTrackSummary([
            'id'         => 1,
            'artist'     => 'Sheila On 7',
            'title'      => 'Kisah Klasik Untuk Masa Depan',
            'total_song' => 1,
        ]);

        $this->assertSame(1, $albumTrackSummary->id);
        $this->assertSame('Sheila On 7', $albumTrackSummary->artist);
        $this->assertSame('Kisah Klasik Untuk Masa Depan', $albumTrackSummary->title);
        $this->assertSame(1, $albumTrackSummary->total_song);
    }
}
