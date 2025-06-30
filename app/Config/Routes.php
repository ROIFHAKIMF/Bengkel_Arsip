<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman publik (untuk pengunjung / guest)
$routes->get('/', 'DashboardController::index');

// Autentikasi
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::processLogin');
$routes->get('logout', 'AuthController::logout');

// Halaman dashboard dan manajemen data (khusus admin)
$routes->group('admin', ['filter' => 'rolefilter'], function ($routes) {
    $routes->get('/', 'DashboardController::admin');

    // Service (Layanan)
    $routes->post('service/tambah', 'DashboardController::simpanLayanan');
    $routes->post('service/edit/(:num)', 'DashboardController::perbaruiLayanan/$1');
    $routes->post('service/hapus', 'DashboardController::hapusLayanan');

    // About
    $routes->post('about/tambah', 'DashboardController::tambahAbout');
    $routes->post('about/edit', 'DashboardController::editAbout');
    $routes->post('about/hapus', 'DashboardController::hapusAbout');

    // Client
    $routes->post('client/tambah', 'DashboardController::tambahClient');
    $routes->post('client/edit', 'DashboardController::editClient');
    $routes->post('client/hapus', 'DashboardController::hapusClient');
});