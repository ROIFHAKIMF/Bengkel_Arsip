<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Halaman Utama dan Halaman Publik (Guest)
$routes->get('/', 'DashboardController::index'); // Halaman Home (dapat diakses oleh guest)n Contact (dapat diakses oleh guest)
// Halaman Login
$routes->get('login', 'AuthController::login'); // Halaman Login
$routes->post('login', 'AuthController::processLogin'); // Proses Login
$routes->get('logout', 'AuthController::logout'); // Logout

// Halaman Dashboard berdasarkan Role
$routes->get('admin', 'DashboardController::admin', ['filter' => 'rolefilter']);
$routes->get('user', 'DashboardController::user', ['filter' => 'rolefilter']);



