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
		
		if (isset($_POST['csrf']))
			{ $this->csrf = $_POST['csrf']; }
		else
			{ $this->csrf = 0; }
		
		$this->model = new tasks_model();
		}
	
	public function show($id)
		{
		$data = [];
		$id < 2 || is_array($id) ? $id = 1: (int)$id;

		$data = $this->model->get_data($id);
		$data['page'] = $id;
		
		$data['page_limit'] = ceil($data['count'] / $GLOBALS['tasks_per_page']);
		
		
		$data['admin'] = $_SESSION['admin_mode'];
		
		$this->view->generate('tasks.view.php', 'main.view.php', $data);
		}
	public function login()
		{	
		$this->view->generate('login.view.php', 'main.view.php');
		}

	public function add()
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

	public function del()
		{
		$task_id = $_POST['id'];
		
		if ( isset($_SESSION['csrf_token']) && 
			       $_SESSION['csrf_token'] == $this->csrf && 
				   $_SESSION['admin_mode'] === 1)
			{
			$result = $this->model->delete_data($task_id);

			if ($result === 1)
				{ echo 'DELETE OK'; }
			else
				{ echo 'DELETE FAIL'; }
			}
		}

	public function done_undone_task()
		{
		$task_id = $_POST['id'];
		$current_active = $_POST['done'];
		
		if ( isset($_SESSION['csrf_token']) && 
			       $_SESSION['csrf_token'] == $this->csrf && 
				   $_SESSION['admin_mode'] === 1)
			{
			$result = $this->model->done_undone_data($current_active, $task_id);

			echo $result;
			}
		}

	public function edit_task()
		{
		$task_id = $_POST['id'];
		$new_task_text = $_POST['text'];
		
		if ( isset($_SESSION['csrf_token']) && 
			       $_SESSION['csrf_token'] == $this->csrf && 
				   $_SESSION['admin_mode'] === 1)
			{
			if ( $this->validate($new_task_text, 'text') === FALSE )
				{ echo 'TEXT TOO SHORT'; }
			else
				{
				$result = $this->model->update_data($new_task_text, $task_id);

				if ($result === 1)
					{ echo 'EDITED'; }
				else
					{ echo 'EDIT FAIL'; }
				}
			}
		}

	public function validate($item, $mode)
		{
		if ($mode === 'text')
			{ return strlen($item) > 2 ? TRUE : FALSE; }
		if ($mode === 'content')
			{ return strlen($item) > 9 ? TRUE : FALSE; }
		if ($mode === 'email')
			{ return filter_var($item, FILTER_VALIDATE_EMAIL) ? TRUE : FALSE; }
		}
	}