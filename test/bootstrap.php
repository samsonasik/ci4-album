<?php

require_once 'vendor/codeigniter4/framework/system/Test/bootstrap.php';

$routes = \Config\Services::routes();
$routes->getRoutes('*');
