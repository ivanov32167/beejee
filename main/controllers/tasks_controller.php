<?php

namespace my\controllers;

use my\models\tasks_model;

class tasks_controller
	{
	private $model;
	private $view;
	private $csrf;
	
	public function __construct()
		{
		$this->view = new views_controller();
		
		if ( isset($_POST['csrf']) )	{ $this->csrf = $_POST['csrf']; }
		else							{ $this->csrf = 0; }
		
		$this->model = new tasks_model();
		}
	
	public function show($page) // отображение основного списка задач
		{
		$page < 2 || is_array($page) ? $page = 1: (int)$page; // нормализация номер страницы

		$data['page'] = $page;
		$data['admin'] = $_SESSION['admin_mode'];

		// установка флажков фильтра НАЧАЛО
		if (!isset($_SESSION['filters'])) { $_SESSION['filters'] = []; }
		$data['filters']['user'] = isset($_SESSION['filters']['user']) ? $_SESSION['filters']['user'] : 1;
		$data['filters']['mail'] = isset($_SESSION['filters']['mail']) ? $_SESSION['filters']['mail'] : 1;
		$data['filters']['done'] = isset($_SESSION['filters']['done']) ? $_SESSION['filters']['done'] : 1;
		// установка флажков фильтра КОНЕЦ
		
		// получение записей из бд НАЧАЛО
		$data_from_db = $this->model->get_data($data);
		$data['posts'] = $data_from_db['posts'];
		$data['page_limit'] = ceil($data_from_db['count'] / $GLOBALS['tasks_per_page']);
		$data['count'] = $data_from_db['count'];
		// получение записей из бд КОНЕЦ
		
		if ($data['page_limit'] > 0 AND $data['page'] > $data['page_limit']) // если требуемая страница больше существующей, идем на 404
			{ return self::page_404(); }
		else
			{ $content_view = 'tasks.view.php'; }
		
		$this->view->generate($content_view, 'main.view.php', $data);
		}

	public function page_404() // 404я ошибка
		{
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		$this->view->generate('404.view.php', 'main.view.php', null);
		}

	public function login() // отображение страницы авторизации
		{	
		$this->view->generate('login.view.php', 'main.view.php');
		}

	public function add() // добавление новой задачи
		{
		if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] == $this->csrf)
			{
			if ($this->validate($_POST['user'], 'text')			=== TRUE &&
				$this->validate($_POST['email'], 'email')		=== TRUE &&
				$this->validate($_POST['content'], 'content')	=== TRUE)
				{
				$add_data['user'] = $_POST['user'];
				$add_data['email'] = $_POST['email'];
				$add_data['content'] = $_POST['content'];
				
				$this->model->set_data($add_data);
				$data['done'] = ['content' => 'task has added'];
				
				echo 'TASK ADDED';
				}
			else
				{ echo 'TASK ADD ERROR'; }
			}
		else
			{ echo 'CSRF ERROR'; }
		}

	public function del() // удаление задачи
		{
		$task_id = $_POST['id'] + 0;
		
		if ($_SESSION['admin_mode'] !== 1)
			{
			echo 'NEED LOGIN';
			}
		elseif ( isset($_SESSION['csrf_token']) && 
			       $_SESSION['csrf_token'] == $this->csrf)
			{
			$result = $this->model->delete_data($task_id);

			if ($result === 1)
				{ echo 'DELETE OK'; }
			else
				{ echo 'DELETE FAIL'; }
			}
		}

	public function done_undone_task() // изменение флага задачи выполнена/не выполнена
		{
		if ($_SESSION['admin_mode'] !== 1)
			{
			echo 'NEED LOGIN';
			}
		if ( isset($_SESSION['csrf_token']) && 
			       $_SESSION['csrf_token'] == $this->csrf)
			{
			$result = $this->model->done_undone_data($_POST['done'] + 0, $_POST['id'] + 0);

			echo $result;
			}
		}

	public function edit_task() // редактирование текста задачи
		{
		$new_task_text = $_POST['text'];
		
		if ($_SESSION['admin_mode'] !== 1)
			{
			echo 'NEED LOGIN';
			}
		if ( isset($_SESSION['csrf_token']) && 
			       $_SESSION['csrf_token'] == $this->csrf)
			{
			if ( $this->validate($new_task_text, 'text') === FALSE )
				{ echo 'TEXT TOO SHORT'; }
			else
				{
				$result = $this->model->update_data(trim($new_task_text), $_POST['id'] + 0);

				if ($result === 1)	{ echo 'EDITED'; }
				else				{ echo 'EDIT FAIL'; }
				}
			}
		}

	public function filter_task() // изменение режима фильтров списка задач
		{
		if (isset($_POST['filter_mode']) AND ($_POST['filter_mode'] === 'user' 
										   OR $_POST['filter_mode'] === 'mail' 
										   OR $_POST['filter_mode'] === 'done'))
			{
			$filter_mode = $_POST['filter_mode'];
			
			if (isset($_SESSION['filters'][$filter_mode])) // изменение режима фильтров 1 -> 2, 2 -> 0, 0 -> 1
				{
				if ($_SESSION['filters'][$filter_mode] === 0)		{ $_SESSION['filters'][$filter_mode] = 1; }
				elseif($_SESSION['filters'][$filter_mode] === 1)	{ $_SESSION['filters'][$filter_mode] = 2; }
				else												{ $_SESSION['filters'][$filter_mode] = 0; }
				}
			else
				{ $_SESSION['filters'][$filter_mode] = 0; } // режим фильтра по умолчанию (0 - выключен)

			echo strtoupper($filter_mode);
			}
		else
			{ return 'FAIL FILTER CHECK'; }
		}

	public function validate($item, $mode) // базовые проверки данных новой задачи
		{
		if ($mode === 'text')		{ return strlen($item) > 0							? TRUE : FALSE; }
		if ($mode === 'content')	{ return strlen($item) > 0							? TRUE : FALSE; }
		if ($mode === 'email')		{ return filter_var($item, FILTER_VALIDATE_EMAIL)	? TRUE : FALSE; }
		}
	}