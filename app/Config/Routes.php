<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman publik (untuk pengunjung / guest)
$routes->get('/', 'GuestController::index');
$routes->get('/admin', 'AdminController::index');

// Autentikasi
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::processLogin');
$routes->get('logout', 'AuthController::logout');

// Halaman dashboard dan manajemen data (khusus admin)
$routes->group('admin', ['filter' => 'rolefilter'], function ($routes) {
    $routes->get('/', 'AdminController::admin');
    // Service (Layanan)
    $routes->post('service/tambah', 'AdminController::tambahService');
    $routes->post('service/edit', 'AdminController::editService');
    $routes->post('service/hapus', 'AdminController::hapusService');
    // About
    $routes->post('about/tambah', 'AdminController::tambahAbout');
    $routes->post('about/edit', 'AdminController::editAbout');
    $routes->post('about/hapus', 'AdminController::hapusAbout'); 
    
    $routes->post('client/tambah', 'AdminController::tambahClient');
    $routes->post('client/edit', 'AdminController::editClient');
    $routes->post('client/hapus', 'AdminController::hapusClient');
    // Routes untuk CRUD Gallery
    $routes->post('gallery/tambah', 'AdminController::tambahgallery');
    $routes->post('gallery/edit', 'AdminController::editgallery');
    $routes->post('gallery/hapus', 'AdminController::hapusgallery');
});
// Routes untuk CRUD Client

$routes->get('/footer', 'AdminController::footer');
$routes->post('/update-social-media', 'AdminController::updateSocialMedia');