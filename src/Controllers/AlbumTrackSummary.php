<?php

/**
 * This file is part of samsonasik/ci4-album.
 *
 * (c) 2020 Abdul Malik Ikhsan <samsonasik@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Album\Controllers;

use Album\Domain\AlbumTrackSummary\AlbumTrackSummaryRepository;
use Album\Models\AlbumModel;
use App\Controllers\BaseController;
use Config\Services;

final class AlbumTrackSummary extends BaseController
{
    /**
     * @var AlbumTrackSummaryRepository
     */
    private $repository;

    public function __construct()
    {
        $this->repository = Services::albumTrackSummary();
    }

    public function totalsong(): string
    {
        $data['summary'] = $this->repository->findPaginatedSummaryTotalSongData();
        $data['pager']   = model(AlbumModel::class)->pager;

        return view('Album\Views\album-track-summary\totalsong', $data);
    }
}
