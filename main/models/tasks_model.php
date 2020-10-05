<?php

namespace my\models;

class tasks_model
	{
	private $db_handler; // указатель на текущую бд

	function __construct()
		{
		$this->check_db();
		}

	public function check_db() // подключение/проверка бд
		{
		if ($this->db_handler == NULL)
			{
			$this->db_handler = new \PDO("sqlite:" . $GLOBALS['db_way']); // создание инстанса бд
			}
		
		if (!filesize($GLOBALS['db_way'])) // если база пустая, или ее нет
			{ die('отсутствует база или таблицы в ней'); }
		}

	public function get_data($data) // получение задач, в соответствии со страницей, лимитом и фильтрами
		{
		$limit = $GLOBALS['tasks_per_page'];
		$offset = $limit * ($data['page'] - 1);

		// получение общего количества задач НАЧАЛО
		$stmt = $this->db_handler->prepare("SELECT count(*) FROM posts");
		$stmt->execute();
		$result = $stmt->fetch();
		
		$result['count'] = $result['count(*)'] + 0;
		// получение общего количества задач КОНЕЦ
		
		// составление строки SQL запроса НАЧАЛО
		$query_str = "SELECT id, u_name, u_mail, task_text, active, edited FROM posts ORDER BY";

		$data['filters']['user'] === 1 ? $filters_set[] = 'u_name COLLATE NOCASE ASC' : 
			($data['filters']['user'] === 2 ? $filters_set[] = 'u_name COLLATE NOCASE DESC' : null);
		
		$data['filters']['mail'] === 1 ? $filters_set[] = 'u_mail COLLATE NOCASE ASC' :
			($data['filters']['mail'] === 2 ? $filters_set[] = 'u_mail COLLATE NOCASE DESC' : null);
		
		$data['filters']['done'] === 1 ? $filters_set[] = 'active ASC' :
			($data['filters']['done'] === 2 ? $filters_set[] = 'active DESC': null);
		
		$filters_set[] = 'created DESC';

		$query_str .= ' ' . implode(', ', $filters_set);
		$query_str .= " LIMIT :how_much OFFSET :from_task";
		// составление строки SQL запроса КОНЕЦ
		
		// исполнение SQL запроса НАЧАЛО
		$stmt = $this->db_handler->prepare($query_str);
		
		$stmt->bindParam(':how_much',		$limit,		\PDO::PARAM_INT);
		$stmt->bindParam(':from_task',		$offset,	\PDO::PARAM_INT);

		$stmt->execute();

		$result['posts'] = $stmt->fetchAll();
		// исполнение SQL запроса КОНЕЦ
		
		return $result;
		}

	public function set_data($add_data) // добавление новой задачи в бд
		{
		$timestamp = time();
		
		foreach($add_data as $key => $value)
			{
			$add_data[$key] = htmlspecialchars($value); // базовая очистка данных отправляемых в бд
			}
		
		$stmt = $this->db_handler->prepare("INSERT INTO posts (u_name, u_mail, task_text, created)"
													. "VALUES(:user,  :mail,  :text,    :created)");
		$stmt->bindParam(':user',		$add_data['user']);
		$stmt->bindParam(':mail',		$add_data['email']);
		$stmt->bindParam(':text',		$add_data['content']);
		$stmt->bindParam(':created',	$timestamp);
		$stmt->execute();
		
		$stmt->fetchColumn();
		$result = $stmt->rowCount();
		
		return $result;
		}

	public function delete_data($id) // удаление задачи из бд
		{
		
		$stmt = $this->db_handler->prepare("DELETE FROM posts WHERE id = :task_id");
		$stmt->bindParam(':task_id', $id, \PDO::PARAM_INT);

		$stmt->execute();
		$result = $stmt->rowCount();

		return $result;
		}

	public function done_undone_data($current_active_flag, $id) // изменение статуса задачи
		{
		if ((int)$current_active_flag === 0)	{ $new_active_flag = 1; }
		else									{ $new_active_flag = 0; }
		
		$stmt = $this->db_handler->prepare("UPDATE posts SET active = :new_active WHERE id = :task_id");
		
		$stmt->bindParam(':new_active', $new_active_flag,	\PDO::PARAM_INT);
		$stmt->bindParam(':task_id',	$id,				\PDO::PARAM_INT);

		$stmt->execute();
		
		return $new_active_flag;
		}
	public function update_data($new_text, $id) // изменение текста задачи
		{
		$timestamp = time();
		$new_text = htmlspecialchars($new_text);
		$stmt = $this->db_handler->prepare("UPDATE posts SET task_text = :new_text, edited = :has_edited WHERE id = :task_id");
		
		$stmt->bindParam(':new_text', $new_text);
		$stmt->bindParam(':task_id',  $id, \PDO::PARAM_INT);
		$stmt->bindParam(':has_edited',  $timestamp, \PDO::PARAM_INT);

		$stmt->execute();
		$result = $stmt->rowCount();

		return $result;
		}
	}