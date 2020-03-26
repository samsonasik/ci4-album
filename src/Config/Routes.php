<?php namespace Album\Config;

$routes->group('album', ['namespace' => 'Album\Controllers'], function ($routes) {
	// URI: /album
	$routes->get('', 'Album::index', ['as' => 'album-index']);

	// URI: /album/add
	$routes->match(['get', 'post'], 'add', 'Album::add', ['as' => 'album-add']);

	// example URI: /album/delete/1
	$routes->get('delete/(:num)', 'Album::delete/$1', ['as' => 'album-delete']);

	// example URI: /album/1
	$routes->match(['get', 'post'], 'edit/(:num)', 'Album::edit/$1', ['as' => 'album-edit']);
});

$routes->group('track', ['namespace' => 'Album\Controllers'], function ($routes) {
	// URI: /track/1
	$routes->get('(:num)', 'Track::index/$1', ['as' => 'track-index']);

	// URI: /track/add/(:num)
	$routes->match(['get', 'post'], 'add/(:num)', 'Track::add/$1', ['as' => 'track-add']);

	// example URI: /track/delete/1
	$routes->get('delete/(:num)', 'Track::delete/$1', ['as' => 'track-delete']);

	// example URI: /track/1
	$routes->match(['get', 'post'], 'edit/(:num)', 'Track::edit/$1', ['as' => 'track-edit']);
});
