<?php namespace Album\Domain\Track;

use Album\Domain\Exception\RecordNotFoundException;

class TrackNotFoundException extends RecordNotFoundException
{
	public final static function forAlbumTrackDoesnotExistOfId(int $id) : self
	{
		return new self(sprintf(
			'The album track with track ID %d you requested does not exist.',
			$id
		));
	}
}
