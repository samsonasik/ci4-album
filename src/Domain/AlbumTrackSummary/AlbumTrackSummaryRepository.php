<?php namespace Album\Domain\AlbumTrackSummary;

interface AlbumTrackSummaryRepository
{
	public function getSummaryAlbumTrackTotalSong(): array;
}
