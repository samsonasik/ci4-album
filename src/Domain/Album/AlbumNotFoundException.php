<?php namespace Album\Domain\Album;

use Album\Domain\Exception\RecordNotFoundException;

class AlbumNotFoundException extends RecordNotFoundException
{
	public final static function forAlbumDoesnotExistOfId(int $id): self
	{
		return new self(sprintf(
			'The album with album ID %d you requested does not exist.',
			$id
		));
	}
}
