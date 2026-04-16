<?php

define('BASE_URL', '/GameCafe_Manager_PRJ/public');
//echo "start";
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use Core\Router;

$router = new Router();

// HOME
$router->get('/', 'AuthController@home');
$router->get('/home', 'AuthController@home');

// AUTH
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout', ['AuthMiddleware']);

// GAMES
$router->get('/games', 'GameController@index', ['AuthMiddleware']);
$router->get('/games/create', 'GameController@create', ['AdminMiddleware']);
$router->post('/games', 'GameController@store', ['AdminMiddleware']);
$router->get('/games/{id}', 'GameController@show', ['AuthMiddleware']);
$router->get('/games/{id}/edit', 'GameController@edit', ['AdminMiddleware']);
$router->post('/games/{id}/update', 'GameController@update', ['AdminMiddleware']);
$router->post('/games/{id}/add-copy', 'GameController@addCopy', ['AdminMiddleware']);
$router->post('/games/{id}/delete', 'GameController@destroy', ['AdminMiddleware']);

// RESERVATIONS
$router->get('/reservations', 'ReservationController@index', ['AdminMiddleware']);
$router->get('/reservations/create', 'ReservationController@create', ['AuthMiddleware']);
$router->post('/reservations', 'ReservationController@store', ['AuthMiddleware']);
$router->get('/reservations/my-reservations', 'ReservationController@mine', ['AuthMiddleware']);
$router->get('/reservations/my', 'ReservationController@mine', ['AuthMiddleware']);
$router->get('/reservations/{id}', 'ReservationController@show', ['AuthMiddleware']);
$router->post('/reservations/{id}/status', 'ReservationController@updateStatus', ['AdminMiddleware']);
$router->post('/reservations/{id}/table', 'ReservationController@updateTable', ['AdminMiddleware']);
$router->post('/reservations/delete', 'ReservationController@delete', ['AdminMiddleware']);
$router->post('/reservations/available', 'ReservationController@available', ['AuthMiddleware']);

// SESSIONS
$router->get('/sessions/dashboard', 'SessionController@dashboard', ['AdminMiddleware']);
$router->get('/sessions/create', 'SessionController@create', ['AdminMiddleware']);
$router->post('/sessions', 'SessionController@store', ['AdminMiddleware']);
$router->post('/sessions/{id}/end', 'SessionController@end', ['AdminMiddleware']);
$router->get('/sessions/history',   'SessionController@history', ['AdminMiddleware']);

// RUN
$router->dispatch();