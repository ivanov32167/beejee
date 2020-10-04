<?php
namespace my\router;

final class router
	{
	public static $routes = array();
	private static $params = array();
	public static $requestedUrl = '';
	
	public static $test = 0;

	public static function add_route($way, $controller) //Добавить маршрут
		{
		if (is_string($way) && is_string($controller))
			{ $route = array($way => $controller); }
		else 
			{ die('не указан путь или контроллер'); }

		self::$routes = array_merge(self::$routes, $route); // добавили путь -> контроллер
		}

	public static function detect_way($way) // Нормализовать URI
		{
		$base_way = preg_replace('%[^\/]{0,}$%', '', $_SERVER['PHP_SELF']); // удаление index.php
		$current_way = $_SERVER['REQUEST_URI'];

		$actual_way = preg_replace('%^(.*'.preg_quote($base_way, '/').')%', '', $current_way); // удаление общих путей
		
		return '/' .trim($actual_way, '/');
		}

	public static function check_route() // Обработка переданного URL
		{
		self::$requestedUrl = self::detect_way($_SERVER["REQUEST_URI"]);
		$requestedUrl = self::$requestedUrl;
		
		self::test('<h2>1</h2>');
		self::test($requestedUrl);
		self::test($_SERVER["REQUEST_URI"]);
		
		if (isset(self::$routes[$requestedUrl])) // если URL и маршрут полностью совпадают
			{
			self::$params = explode('/', self::$routes[$requestedUrl]);
			
			self::test('<h2>2</h2>');
			self::test(self::$params);
			
			return self::execute_controller();
			}

		self::test('<h2>2</h2>');
		self::test(self::$routes);
			
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

				return self::execute_controller();
				break;
				}
			}
		echo '404 error';
		}

	public static function execute_controller() // Запуск соответствующего действия/экшена/метода контроллера
		{
		if (!isset(self::$params[0])) // не указан контроллер
			{ die('ошибка контроллера'); }
		if (!isset(self::$params[1])) // метод контроллера по умолчанию - show
			{ self::$params[1] = 'show'; }
		if (!isset(self::$params[2])) // параметры (по умолчанию пустой массив)
			{ self::$params[2] = []; }

		$controller = self::$params[0];
		$method = self::$params[1];

		$controller = new $controller();

		return call_user_func_array(array($controller, $method), array(self::$params[2]));
		}

	public static function test($var) // тестовый вывод, потом удалить
		{
		if (self::$test === 1)
			{
			if(is_array($var))
				{
				echo '<PRE>';
				print_r($var);
				echo '</PRE>';
				}
			else
				{
				echo $var.'<BR>';
				}
			}
		}
	}