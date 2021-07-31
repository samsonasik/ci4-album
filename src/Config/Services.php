<?php namespace Album\Config;

use Album\Models\AlbumModel;
use Album\Models\TrackModel;
use Album\Infrastructure\Persistence\Album\SQLAlbumRepository;
use Album\Infrastructure\Persistence\AlbumTrackSummary\SQLAlbumTrackSummaryRepository;
use Album\Infrastructure\Persistence\Track\SQLTrackRepository;
use Album\Models;
use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
	public static function albumRepository($getShared = true)
	{
		if ($getShared)
		{
			return static::getSharedInstance('albumRepository');
		}

		return new SQLAlbumRepository(model(AlbumModel::class));
	}

	public static function trackRepository($getShared = true)
	{
		if ($getShared)
		{
			return static::getSharedInstance('trackRepository');
		}

		return new SQLTrackRepository(model(TrackModel::class));
	}

	public static function albumTrackSummary($getShared = true)
	{
		if ($getShared)
		{
			return static::getSharedInstance('albumTrackSummary');
		}

		return new SQLAlbumTrackSummaryRepository(
			model(AlbumModel::class),
			model(TrackModel::class)
		);
	}
}
