<?php
namespace my\router;
use my\controllers;
final class router
	{
	public static $routes = array();
	private static $params = array();
	public static $requestedUrl = '';
	
	private static $default_controller = 'my\controllers\tasks_controller';
	private static $default_method = 'page_404';

	public static function add_route($way, $controller) // добавление маршрута
		{
		if (is_string($way) && is_string($controller))
			{ $route = array($way => $controller); }
		else 
			{ die('не указан путь или контроллер'); }

		self::$routes = array_merge(self::$routes, $route); // добавление пути -> класса
		}

	public static function detect_way($way) // Нормализация URI
		{
		$base_way = preg_replace('%[^\/]{0,}$%', '', $_SERVER['PHP_SELF']); // удаление index.php

		$actual_way = preg_replace('%^(.*'.preg_quote($base_way, '/').')%', '', $_SERVER['REQUEST_URI']); // удаление общих путей
		
		return '/' .trim($actual_way, '/');
		}

	public static function check_route() // обработка переданного URL
		{
		self::$requestedUrl = self::detect_way($_SERVER["REQUEST_URI"]);
		$requestedUrl = self::$requestedUrl;

		if (isset(self::$routes[$requestedUrl])) // если URL и маршрут полностью совпадают
			{
			self::$params = explode('/', self::$routes[$requestedUrl]);
			
			return self::execute_controller();
			}

		foreach (self::$routes as $route => $uri) 
			{
			if (strpos($route, ':num')) // достаем параметр (номер страницы)
				{ $route =  str_replace(':num', '([0-9]+)', $route); }

			if (preg_match('#^'.$route.'$#', $requestedUrl))
				{
				if (strpos($uri, '$') && strpos($route, '(')) 
					{ $uri = preg_replace('#^'.$route.'$#', $uri, $requestedUrl); }
				
				$uri = explode('/', $uri);
				for ($p = 0; $p < 3; $p++)
					{ self::$params[$p] = array_shift($uri); }

				return self::execute_controller();


				
				break;
				}
			}
		
		// если путь не найден, идем на 404
		self::$params[0] = self::$default_controller;
		self::$params[1] = self::$default_method;
		self::$params[2] = [];
		
		return self::execute_controller();
		}

	public static function execute_controller() // Запуск соответствующего метода класса
		{
		if (!isset(self::$params[0])) { die('ошибка: не существующий класс'); }
		if (!isset(self::$params[1])) { self::$params[1] = 'show'; } // метод по умолчанию
		if (!isset(self::$params[2])) { self::$params[2] = []; }	// параметры (по умолчанию пустой массив)

		$controller = self::$params[0];
		$method = self::$params[1];

		$controller = new $controller();

		return call_user_func_array(array($controller, $method), array(self::$params[2])); // запуск класса
		}
	}