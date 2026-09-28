<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ============================================================
// SHIELD AUTH ROUTES (login, register, magic-link, logout, dll)
// ============================================================
service('auth')->routes($routes);

// ============================================================
// HOME / ROOT
// ============================================================
$routes->get('/', function () {
    if (auth()->loggedIn()) {
        return redirect()->to('/dashboard');
    }
    return redirect()->to('/login');
});

// Dashboard: semua role yang login
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'session']);

// ============================================================
// MODUL OPERASIONAL
// ============================================================

// Kamar: admin, manager, front_office, housekeeping (view only untuk FO/HK)
$routes->group('rooms', ['filter' => 'group:admin,manager,front_office,housekeeping'], function ($routes) {
    $routes->get('/', 'Room::index');
});
$routes->group('rooms', ['filter' => 'group:admin,manager'], function ($routes) {
    $routes->post('store', 'Room::store');
    $routes->post('update/(:num)', 'Room::update/$1');
    $routes->post('delete/(:num)', 'Room::delete/$1');
});

// Tipe Kamar: hanya admin, manager
$routes->group('room-types', ['filter' => 'group:admin,manager'], function ($routes) {
    $routes->get('/', 'RoomType::index');
    $routes->post('store', 'RoomType::store');
    $routes->post('update/(:num)', 'RoomType::update/$1');
    $routes->post('delete/(:num)', 'RoomType::delete/$1');
});

// Denah Kamar: semua yang login (FO + HK butuh ini)
$routes->group('room-map', ['filter' => 'session'], function ($routes) {
    $routes->get('/', 'RoomMap::index');
    $routes->get('data', 'RoomMap::data');
    $routes->post('update-status/(:num)', 'RoomMap::updateStatus/$1');
});

// Tamu: admin, manager, front_office
$routes->group('guests', ['filter' => 'group:admin,manager,front_office'], function ($routes) {
    $routes->get('/', 'Guest::index');
    $routes->post('store', 'Guest::store');
    $routes->post('update/(:num)', 'Guest::update/$1');
    $routes->post('delete/(:num)', 'Guest::delete/$1');
});

// Reservasi: admin, manager, front_office
$routes->group('reservations', ['filter' => 'group:admin,manager,front_office'], function ($routes) {
    $routes->get('/', 'Reservation::index');
    $routes->post('store', 'Reservation::store');
    $routes->post('update/(:num)', 'Reservation::update/$1');
    $routes->post('update-status/(:num)', 'Reservation::updateStatus/$1');
    $routes->post('delete/(:num)', 'Reservation::delete/$1');
    $routes->post('check-availability', 'Reservation::checkAvailability');
    $routes->get('invoice/(:num)', 'Reservation::invoice/$1');
});

// Housekeeping: admin, manager, housekeeping
$routes->group('housekeeping', ['filter' => 'group:admin,manager,housekeeping'], function ($routes) {
    $routes->get('/', 'Housekeeping::index');
    $routes->post('store', 'Housekeeping::store');
    $routes->post('update/(:num)', 'Housekeeping::update/$1');
    $routes->post('update-status/(:num)', 'Housekeeping::updateStatus/$1');
    $routes->post('upload-photo/(:num)', 'Housekeeping::uploadPhoto/$1');
    $routes->post('delete/(:num)', 'Housekeeping::delete/$1');
});

// ============================================================
// MODUL INVENTORI
// ============================================================

// Barang: admin, manager, purchasing
$routes->group('items', ['filter' => 'group:admin,manager,purchasing'], function ($routes) {
    $routes->get('/', 'Item::index');
    $routes->post('store', 'Item::store');
    $routes->post('update/(:num)', 'Item::update/$1');
    $routes->post('delete/(:num)', 'Item::delete/$1');
    $routes->post('category/store', 'Item::categoryStore');
    $routes->post('category/update/(:num)', 'Item::categoryUpdate/$1');
    $routes->post('category/delete/(:num)', 'Item::categoryDelete/$1');
});

// Supplier: admin, manager, purchasing
$routes->group('suppliers', ['filter' => 'group:admin,manager,purchasing'], function ($routes) {
    $routes->get('/', 'Supplier::index');
    $routes->post('store', 'Supplier::store');
    $routes->post('update/(:num)', 'Supplier::update/$1');
    $routes->post('delete/(:num)', 'Supplier::delete/$1');
});

// Purchasing: admin, manager, purchasing
$routes->group('purchasing', ['filter' => 'group:admin,manager,purchasing'], function ($routes) {
    $routes->get('/', 'Purchasing::index');
    $routes->post('store', 'Purchasing::store');
    $routes->post('approve/(:num)', 'Purchasing::approve/$1');
    $routes->post('deliver/(:num)', 'Purchasing::deliver/$1');
    $routes->post('delete/(:num)', 'Purchasing::delete/$1');
    $routes->get('detail/(:num)', 'Purchasing::detail/$1');
});

// ============================================================
// MODUL LAINNYA
// ============================================================

// Laporan: admin, manager
$routes->group('reports', ['filter' => 'group:admin,manager'], function ($routes) {
    $routes->get('/', 'Report::index');
    $routes->get('data', 'Report::data');
    $routes->post('pdf', 'Report::pdf');
});

// Pengaturan: hanya admin
$routes->group('settings', ['filter' => 'group:admin'], function ($routes) {
    $routes->get('/', 'Settings::index');
    $routes->post('save-hotel', 'Settings::saveHotel');
    $routes->post('save-tax', 'Settings::saveTax');
    $routes->post('user/store', 'Settings::userStore');
    $routes->post('user/update/(:num)', 'Settings::userUpdate/$1');
    $routes->post('user/reset-password/(:num)', 'Settings::userResetPassword/$1');
    $routes->post('user/delete/(:num)', 'Settings::userDelete/$1');
});
// Halaman 403 custom
$routes->get('403', function() {
    return view('errors/html/error_403');
});