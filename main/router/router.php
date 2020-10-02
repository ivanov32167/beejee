<?php
namespace my\router;


final class router
	{
	public static $routes = array();
	private static $params = array();
	private static $requestedUrl = '';

	public static function add_route($way, $controller) //Добавить маршрут
		{
		if (is_string($way) && is_string($controller))
			{ $route = array($way => $controller); }
		else 
			{ die('не указан путь или контроллер'); }

		self::$routes = array_merge(self::$routes, $route); // добавили путь -> контроллер
		}

	public static function detect_way() // Разделить переданный URL на компоненты
		{
		$base_way = preg_replace('%[^\/]{0,}$%', '', $_SERVER['PHP_SELF']); // путь к index.php
		$current_way = $_SERVER['REQUEST_URI'];

		$actual_way = str_replace($base_way, '', $current_way); // удаление общих путей
		return '/' .trim($actual_way, '/');
		}

	public static function check_route() // Обработка переданного URL
		{
		self::$requestedUrl = self::detect_way($_SERVER["REQUEST_URI"]);

		if (isset(self::$routes[$requestedUrl])) // если URL и маршрут полностью совпадают
			{
			self::$params = explode('/', self::$routes[$requestedUrl]);
			return self::execute_controller();
			}

		foreach (self::$routes as $route => $uri) 
			{
			if (strpos($route, ':num')) // достаем номер страницы
				{ $route =  str_replace(':num', '([0-9]+)', $route); }

			if (preg_match('#^'.$route.'$#', $requestedUrl))
				{
				if (strpos($uri, '$') && strpos($route, '(')) 
					{ $uri = preg_replace('#^'.$route.'$#', $uri, $requestedUrl); }
				
				$uri = explode('/', $uri);
				for ($p = 0; $p < 3; $p++)
					{ self::$params[$p] = array_shift($uri); }

				break;
				}
			}
		return self::execute_controller();
		}

	public static function execute_controller() // Запуск соответствующего действия/экшена/метода контроллера
		{
		if (!isset(self::$params[0])) // не указан контроллер
			{ die('ошибка контроллера'); }
		if (!isset(self::$params[1])) // метод контроллера по умолчанию - index
			{ die('ошибка метода'); }
		if (!isset(self::$params[2])) // параметры (по умолчанию пустой массив)
			{ self::$params[2] = []; }

		return call_user_func_array(array(self::$params[0], self::$params[1]), array(self::$params[2]));
		}
	}