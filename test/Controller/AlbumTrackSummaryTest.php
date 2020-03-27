<?php namespace AlbumTest\Controller;

use Album\Controllers\AlbumTrackSummary;
use Album\Database\Seeds\AlbumSeeder;
use Album\Database\Seeds\TrackSeeder;
use CodeIgniter\Test\CIDatabaseTestCase;
use CodeIgniter\Test\ControllerTester;

class AlbumTrackSummaryTest extends CIDatabaseTestCase
{
	use ControllerTester;

	protected $basePath  = __DIR__ . '/../src/Database/';
	protected $namespace = 'Album';
	protected $seed      = [
		AlbumSeeder::class,
		TrackSeeder::class,
	];

	public function testTotalSongSummary()
	{
		$result = $this->controller(AlbumTrackSummary::class)
					   ->execute('totalsong');

		$this->assertRegExp('/Sheila On 7<\/td>\s{0,}\n\s{0,}<td>1<\/td>/', $result->getBody());
	}
}
