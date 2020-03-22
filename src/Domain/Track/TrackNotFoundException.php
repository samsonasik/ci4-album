<?php namespace Album\Domain\Track;

use Album\Domain\Exception\RecordNotFoundException;

class TrackNotFoundException extends RecordNotFoundException
{
	/** @var string */
	public $message = 'The album track you requested does not exist.';
}
