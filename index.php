<?php
ini_set('display_errors', 1);

require_once './main/autoload.php';

use my\router\router;
use my\models\tasks_model;

session_start();

$controllersNS = 'my\controllers';
$GLOBALS['db_way'] = __DIR__.'\\res\\db\\todos.db';
$GLOBALS['base_web_way'] = str_replace('index.php', '', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
$GLOBALS['tasks_per_page'] = 3;

//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

$router = new router();

$router->add_route('/',				$controllersNS.'\tasks_controller/show');
$router->add_route('/addtask',		$controllersNS.'\tasks_controller/add');
$router->add_route('/:num',			$controllersNS.'\tasks_controller/show/$1');
$router->add_route('/del',			$controllersNS.'\tasks_controller/del');
$router->add_route('/onoff',		$controllersNS.'\tasks_controller/done_undone_task');
$router->add_route('/admin',		$controllersNS.'\tasks_controller/login');
$router->add_route('/edit',			$controllersNS.'\tasks_controller/edit_task');
$router->add_route('/login',		$controllersNS.'\user_controller/login');
$router->add_route('/logout',		$controllersNS.'\user_controller/logout');


$router->check_route();