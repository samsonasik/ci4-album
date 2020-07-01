<?php namespace Album\Controllers\Filters;

use Album\Domain\Exception\RecordNotFoundException;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class RecordNotFound implements FilterInterface
{
	public function before(RequestInterface $request)
	{
		$paths = [
			'album',
			'album-track',
		];
		$uri   = Services::uri();
		$path  = $uri->getSegment(1);

		if (! in_array($path, $paths, true))
		{
			return;
		}

		if ($uri->getTotalSegments() < 3)
		{
			return;
		}

		$albumId = $trackId = false;
		if ($path === 'album')
		{
			$albumId = $uri->getSegment(3);
		}
		else
		{
			if ($uri->getSegment(2) === 'add')
			{
				$albumId = $uri->getSegment(3);
			}
			else
			{
				if ($uri->getTotalSegments() === 3)
				{
					$trackId = $uri->getSegment(3);
				}
				else
				{
					$albumId = $uri->getSegment(3);
					$trackId = $uri->getSegment(4);
				}
			}
		}

		try
		{
			Services::albumRepository()->findAlbumOfId($albumId);
			if ($trackId !== false)
			{
				Services::trackRepository()->findTrackOfId($trackId);
			}
		}
		catch (RecordNotFoundException $e)
		{
			throw PageNotFoundException::forPageNotFound($e->getMessage());
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response)
	{
	}
}
