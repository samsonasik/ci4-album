<?php namespace Album\Infrastructure\Persistence\AlbumTrackSummary;

use Album\Domain\AlbumTrackSummary\AlbumTrackSummary;
use Album\Domain\AlbumTrackSummary\AlbumTrackSummaryRepository;
use Config\Database;

class SQLAlbumTrackSummaryRepository implements AlbumTrackSummaryRepository
{
	public function getSummaryAlbumTrackTotalSong(): array
	{
		$db      = Database::connect();
		$builder = $db->table('album');
		$builder->select([
			'*',
			'('
				. $db->table('track')
					 ->select('count(*)')
					 ->where('album_id = album.id')
					 ->getCompiledSelect() .
			') AS total_song',
		]);

		return $builder->get()->getResult(AlbumTrackSummary::class);
	}
}
