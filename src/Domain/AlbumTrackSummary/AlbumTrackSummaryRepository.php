<?php namespace Album\Domain\AlbumTrackSummary;

interface AlbumTrackSummaryRepository
{
	public function getPaginatedSummaryAlbumTrackTotalSong(): ?array;
}
