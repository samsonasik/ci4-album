<?php

require_once 'vendor/codeigniter4/framework/system/Test/bootstrap.php';

helper('url');

$routes = \Config\Services::routes();
$routes->getRoutes('*');

require_once 'src/Config/Routes.php';
