<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/article/(:segment)', 'Home::article/$1');

$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'AuthFilter', 'namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'Dashboard::index');
    
    $routes->get('settings', 'Settings::index');
    $routes->post('settings', 'Settings::save');
    
    $routes->resource('sliders');
    $routes->resource('services');
    $routes->get('articles', 'Articles::index');
    $routes->get('articles/create', 'Articles::create');
    $routes->get('articles/new', 'Articles::create'); // Alias for legacy/cached links
    $routes->post('articles/store', 'Articles::store');
    $routes->get('articles/edit/(:num)', 'Articles::edit/$1');
    $routes->post('articles/update/(:num)', 'Articles::update/$1');
    $routes->get('articles/delete/(:num)', 'Articles::delete/$1');

    $routes->get('partners', 'Partners::index');
    $routes->get('partners/create', 'Partners::create');
    $routes->post('partners/store', 'Partners::store');
    $routes->get('partners/edit/(:num)', 'Partners::edit/$1');
    $routes->post('partners/update/(:num)', 'Partners::update/$1');
    $routes->get('partners/delete/(:num)', 'Partners::delete/$1');

    $routes->get('certificates', 'Certificates::index');
    $routes->get('certificates/create', 'Certificates::new');
    $routes->post('certificates/store', 'Certificates::create');
    $routes->get('certificates/edit/(:num)', 'Certificates::edit/$1');
    $routes->post('certificates/update/(:num)', 'Certificates::update/$1');
    $routes->get('certificates/delete/(:num)', 'Certificates::delete/$1');

    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
});