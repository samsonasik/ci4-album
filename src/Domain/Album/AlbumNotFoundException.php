<?php namespace Album\Domain\Album;

use Album\Domain\Exception\RecordNotFoundException;

class AlbumNotFoundException extends RecordNotFoundException
{
	/** @var string */
	public $message = 'The album you requested does not exist.';
}
