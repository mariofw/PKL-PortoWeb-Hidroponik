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
    $routes->resource('articles');
});