<?php

require_once __DIR__ . '/../vendor/autoload.php';



use Core\Router;

session_start();

$router = new Router();

$router->get('/home', 'AuthController@home');
// Auth
$router->get('/login',    'AuthController@loginForm');
$router->post('/login',   'AuthController@login');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register','AuthController@register');
$router->post('/logout', 'AuthController@logout', ['AuthMiddleware']);

// Games
$router->get('/games/index', 'GameController@index', ['AuthMiddleware']);
$router->get('/games/create',       'GameController@create');
$router->post('/games',             'GameController@store');
$router->get('/games/{id}',         'GameController@show');
$router->get('/games/{id}/edit',    'GameController@edit');
$router->post('/games/{id}/update', 'GameController@update');
$router->post('/games/{id}/delete', 'GameController@destroy');

// Reservations
$router->get('/reservations',              'ReservationController@index');
$router->get('/reservations/create',       'ReservationController@create');
$router->post('/reservations',             'ReservationController@store');
$router->get('/reservations/my',           'ReservationController@mine');
$router->post('/reservations/available',   'ReservationController@available');
$router->post('/reservations/{id}/status', 'ReservationController@updateStatus');

// Sessions
$router->get('/sessions/dashboard', 'SessionController@dashboard');
$router->get('/sessions/create',    'SessionController@create');
$router->post('/sessions',          'SessionController@store');
$router->post('/sessions/{id}/end', 'SessionController@end');
$router->get('/sessions/history',   'SessionController@history');

$router->dispatch();