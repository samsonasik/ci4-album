<?php

require 'vendor/codeigniter4/framework/system/Test/bootstrap.php';

helper('url');

$routes = \Config\Services::routes();
$routes->getRoutes('*');

require 'src/Config/Routes.php';
