<?php

$routes->group('album', ['namespace' => 'Album\Controllers'], function($routes) {

    $routes->get('', 'Album::index', ['as' => 'album-index']); // URI: /album
    $routes->match(['get', 'post'], 'add', 'Album::add', ['as' => 'album-add']); // URI: /album/add
    $routes->get('delete/(:num)', 'Album::delete/$1', ['as' => 'album-delete']); // URI: /album/add
    $routes->match(['get', 'post'], 'edit/(:num)', 'Album::edit/$1', ['as' => 'album-edit']); // example URI: /album/1

});