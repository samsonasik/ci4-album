<?php

include 'vendor/codeigniter4/framework/system/Test/bootstrap.php';

helper('url');

$routes = \Config\Services::routes();
$routes->getRoutes('*');

include 'src/Config/Routes.php';
