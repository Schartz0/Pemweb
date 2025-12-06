<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/loginProcess', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users', 'UserController::store');
    $routes->get('users/(:num)/edit', 'UserController::edit/$1');
    $routes->post('users/(:num)', 'UserController::update/$1');
    $routes->post('users/(:num)/delete', 'UserController::delete/$1');

    $routes->get('ruangan', 'RuanganController::index');
    $routes->post('ruangan', 'RuanganController::store');
    $routes->post('ruangan/(:segment)', 'RuanganController::update/$1');
    $routes->post('ruangan/(:segment)/delete', 'RuanganController::delete/$1');

    $routes->get('mata-kuliah', 'MataKuliahController::index');
    $routes->get('mata-kuliah/create', 'MataKuliahController::create');
    $routes->post('mata-kuliah', 'MataKuliahController::store');
    $routes->get('mata-kuliah/(:num)/edit', 'MataKuliahController::edit/$1');
    $routes->post('mata-kuliah/(:num)', 'MataKuliahController::update/$1');
    $routes->post('mata-kuliah/(:num)/delete', 'MataKuliahController::delete/$1');

    $routes->get('jadwal', 'JadwalController::index');
    $routes->post('jadwal', 'JadwalController::store');
    $routes->post('jadwal/(:num)', 'JadwalController::update/$1');
    $routes->post('jadwal/(:num)/delete', 'JadwalController::delete/$1');
});

$routes->group('mahasiswa', ['filter' => 'role:mahasiswa'], function ($routes) {
    $routes->get('rencana-studi', 'RencanaStudiController::index');
    $routes->post('rencana-studi', 'RencanaStudiController::store');
    $routes->post('rencana-studi/(:num)/delete', 'RencanaStudiController::destroy/$1');
    $routes->get('hasil-studi', 'RencanaStudiController::hasil');
});

$routes->group('dosen', ['filter' => 'role:dosen'], function ($routes) {
    $routes->get('jadwal', 'DosenController::jadwal');
    $routes->get('jadwal/(:num)/nilai', 'NilaiMutuController::edit/$1');
    $routes->post('jadwal/(:num)/nilai', 'NilaiMutuController::update/$1');
});

