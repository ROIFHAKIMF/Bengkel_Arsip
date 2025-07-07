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
    $routes->post('service/tambah', 'DashboardController::tambahService');
    $routes->post('service/edit', 'DashboardController::editService');
    $routes->post('service/hapus', 'DashboardController::hapusService');
    // About
    $routes->post('about/tambah', 'DashboardController::tambahAbout');
    $routes->post('about/edit', 'DashboardController::editAbout');
    $routes->post('about/hapus', 'DashboardController::hapusAbout'); 
    
    $routes->post('client/tambah', 'DashboardController::tambahClient');
    $routes->post('client/edit', 'DashboardController::editClient');
    $routes->post('client/hapus', 'DashboardController::hapusClient');
    // Routes untuk CRUD Gallery
    $routes->post('gallery/tambah', 'DashboardController::tambahgallery');
    $routes->post('gallery/edit', 'DashboardController::editgallery');
    $routes->post('gallery/hapus', 'DashboardController::hapusgallery');
});
// Routes untuk CRUD Client

$routes->get('/footer', 'DashboardController::footer');
$routes->post('/update-social-media', 'DashboardController::updateSocialMedia');