<?php
ini_set('display_errors', 1);
require_once './main/autoload.php';

use my\router\router;

$router = new router();

$router->add_route('/', 'MainController/show');
$router->add_route('/:num', 'MainController/show/$1');
$router->add_route('/del/:num', 'MainController/del/$1');
$router->add_route('/done/:num', 'MainController/done/$1');
$router->add_route('/admin', 'userController');

$router->check_route();