<?php

use App\Controllers\Home;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/add-or-update-to-do-data','Home::addOrUpdateToDoData');
$routes->post('/get-to-do-list-by-id','Home::getToDoListById');
$routes->post('/delete-to-do-data','Home::deleteToDoData');
