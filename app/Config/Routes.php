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
$routes->get('logout', 'AuthController::logout');// Logout

// Halaman Dashboard berdasarkan Role
$routes->group('admin', ['filter' => 'rolefilter'], function($routes) {
    $routes->get('/', 'DashboardController::admin'); // Halaman Admin Dashboard

// Routes untuk CRUD Service
$routes->get('service/create', 'DashboardController::createService');
$routes->post('service/store', 'DashboardController::storeService');
$routes->get('/service/edit/(:num)', 'DashboardController::editService/$1');
$routes->post('/service/update/(:num)', 'DashboardController::updateService/$1');
$routes->get('/service/delete/(:num)', 'DashboardController::deleteService/$1');

// tambahkan route lain kalau perlu

    $routes->post('about/tambah', 'DashboardController::tambahAbout');
    $routes->post('about/edit', 'DashboardController::editAbout');
    $routes->post('about/hapus', 'DashboardController::hapusAbout'); // ← ini sudah BENAR


});





