<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// AUTH
$routes->get('/', 'AuthController::index');
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
$routes->post('/logout', 'AuthController::logout');

// FILTER
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Redirect root ke tutorial
    $routes->get('/', 'TutorialMasterController::index');

    // Tutorial master
    $routes->get('/tutorial', 'TutorialMasterController::index');
    $routes->get('/tutorial/create', 'TutorialMasterController::create');
    $routes->post('/tutorial/save', 'TutorialMasterController::save'); 
    $routes->get('/tutorial/edit/(:num)', 'TutorialMasterController::edit/$1');
    $routes->post('/tutorial/update/(:num)', 'TutorialMasterController::update/$1');
    $routes->get('/tutorial/delete/(:num)', 'TutorialMasterController::delete/$1');

    // Tutorial detail
    $routes->get('/tutorial/(:num)/detail', 'TutorialDetailController::index/$1');
    $routes->get('/tutorial/(:num)/detail/create_detail', 'TutorialDetailController::create/$1');
    $routes->post('/tutorial/detail/store/(:num)', 'TutorialDetailController::store/$1');
    $routes->get('/tutorial/(:num)/detail/create_detail/(:num)', 'TutorialDetailController::create/$1/$2');
    $routes->post('/tutorial/detail/update/(:num)/(:num)', 'TutorialDetailController::update/$1/$2');
    $routes->post('tutorial/(:num)/detail/(:num)/delete', 'TutorialDetailController::delete/$1/$2');
    $routes->get('/tutorial/(:num)/detail/(:num)/toggle', 'TutorialDetailController::toggleStatus/$1/$2');
    $routes->post('tutorial/(:num)/detail/(:num)/toggle', 'TutorialDetailController::toggleStatus/$1/$2');
});

// BEBAS DIAKSES TANPA LOGIN
$routes->get('presentation/(:segment)', 'PresentationController::show/$1');
$routes->get('finished/(:segment)', 'PresentationController::finished/$1');
$routes->get('api/(:segment)', 'ApiController::getByMatkul/$1');

