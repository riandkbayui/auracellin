<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(true);

if (file_exists(APPPATH . 'Routes/Api.php')) {
    require_once APPPATH . 'Routes/Api.php';
}
if (file_exists(APPPATH . 'Routes/Cli.php')) {
    require_once APPPATH . 'Routes/Cli.php';
}
if (file_exists(APPPATH . 'Routes/Web.php')) {
	require_once APPPATH . 'Routes/Web.php';
}
