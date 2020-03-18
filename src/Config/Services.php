<?php namespace Album\Config;

use Album\Infrastructure\Persistence\Album\SQLAlbumRepository;
use Album\Models\AlbumModel;
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
}
