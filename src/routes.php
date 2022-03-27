<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/login', 'LoginController@signin'); /*processo de login*/
$router->get('/login', 'LoginController@signinAction');
$router->get('/cadastro', 'LoginController@signup'); /*cadastro*/

