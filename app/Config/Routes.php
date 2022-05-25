<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Home::index');

$routes->get('user', 'Users::index');
$routes->get('user/create', 'Users::create');
$routes->post('user/store', 'Users::store');
$routes->get('user/edit/(:alphanum)', 'Users::edit/$1');
$routes->post('user/update/(:alphanum)', 'Users::update/$1');
$routes->get('user/delete/(:alphanum)', 'Users::delete/$1');

$routes->get('kategori', 'Kategori::index');
$routes->get('kategori/create', 'Kategori::create');
$routes->post('kategori/store', 'Kategori::store');
$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');
$routes->get('kategori/restore/(:num)', 'Kategori::restore/$1');
$routes->get('kategori/permanentdelete/(:num)', 'Kategori::permanentdelete/$1');

$routes->get('produk', 'Produk::index');
$routes->get('produk/create', 'Produk::create');
$routes->post('produk/store', 'Produk::store');
$routes->get('produk/edit/(:num)', 'Produk::edit/$1');
$routes->post('produk/update/(:num)', 'Produk::update/$1');
$routes->get('produk/delete/(:num)', 'Produk::delete/$1');
$routes->get('produk/restore/(:num)', 'Produk::restore/$1');
$routes->get('produk/permanentdelete/(:num)', 'Produk::permanentdelete/$1');

$routes->get('/', 'Login::index');
$routes->get('login/index', 'Login::index');
$routes->post('login/proses', 'Login::proses');
$routes->get('home', 'Home::index');
$routes->get('logout', 'Login::logout');


$routes->post('api/login/login', 'Api\Login::login');

$routes->resource('api/kategori', [
	'controller' => 'Api\Kategori',
	'only' => ['index']
]);

$routes->resource('api/produk', [
	'controller' => 'Api\Produk',
	'only' => ['index']
]);

$routes->resource('api/keranjang', [
	'controller' => 'Api\Keranjang',
	'only' => ['create', 'index', 'update', 'delete']
]);

$routes->post('api/checkout', 'Api\Transaksi::checkout');
$routes->get('api/kasir', 'Api\Transaksi::getKasir');
$routes->post('api/transaksi-date', 'Api\Transaksi::getDataByDate');
$routes->post('api/transaksi-kasir', 'Api\Transaksi::getDataByKasir');
$routes->post('api/transaksi/detail', 'Api\Transaksi::getDetailData');
$routes->post('api/chart', 'Api\Transaksi::getChart');
$routes->get('api/export-excel', 'Api\Transaksi::exportExcel');
$routes->get('api/export-pdf', 'Api\Transaksi::exportPdf');

$routes->get('report', 'Report::index');
$routes->get('report/(:num)', 'Report::detail/$1');
$routes->get('report/exportpdf', 'Report::exportPdf');
$routes->get('report/exportexcel', 'Report::exportExcel');




/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
