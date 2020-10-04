<?php

namespace my\models;

class tasks_model
	{
	private $db_tables		= ['users' => 'users', 'posts' => 'posts'];
	
	private $db_handler;

	function __construct()
		{
		$this->check_db($this->db_tables);
		}

	public function check_db($db_tables)
		{
		if ($this->db_handler == NULL)
			{
			$db_path = $GLOBALS['db_way'];
			$this->db_handler = new \PDO("sqlite:" . $db_path);
			}
		else
			{
			die('trouble with db');
			}
		
		if (!filesize($db_path)) // если база пустая, или ее нет
			{ die('отсутствует бд или таблицы в ней'); }
		}

	public function get_data($page)
		{
		$limit = $GLOBALS['tasks_per_page'];
		$offset = $limit * ($page - 1);
		
		$stmt = $this->db_handler->prepare("SELECT count(*) FROM posts");
		$stmt->execute();
		$result = $stmt->fetch();
		$all_tasks_count = $result['count(*)'] + 0;
		
		$stmt = $this->db_handler->prepare("SELECT id, u_name, u_mail, task_text, active FROM posts "
				. "ORDER BY created ASC "
				. "LIMIT :how_much OFFSET :from_task");
		$stmt->bindParam(':how_much',		$limit,		\PDO::PARAM_INT);
		$stmt->bindParam(':from_task',		$offset,	\PDO::PARAM_INT);		

		$stmt->execute();
		$result['posts'] = $stmt->fetchAll();
		$result['count'] = $all_tasks_count;
		
		return $result;
		}

	public function set_data($add_data)
		{
		$timestamp = time();
		
		foreach($add_data as $key => $value)
			{
			$add_data[$key] = htmlspecialchars($value);
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

	public function delete_data($id)
		{
		
		$stmt = $this->db_handler->prepare("DELETE FROM posts WHERE id = :task_id");
		$stmt->bindParam(':task_id', $id, \PDO::PARAM_INT);

		$stmt->execute();
		
		$result = $stmt->rowCount();

		return $result;
		}

	public function done_undone_data($current_active_flag, $id)
		{
		if ((int)$current_active_flag === 0)
			{ $new_active_flag = 1; }
		else
			{ $new_active_flag = 0; }
		
		//$stmt = $this->db_handler->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
		$stmt = $this->db_handler->prepare("UPDATE posts SET active = :new_active WHERE id = :task_id");
		
		$stmt->bindParam(':new_active', $new_active_flag,	\PDO::PARAM_INT);
		$stmt->bindParam(':task_id',	$id,				\PDO::PARAM_INT);

		$stmt->execute();
		
		//$result = $stmt->rowCount();

		return $new_active_flag;
		}
	public function update_data($new_text, $id)
		{
		$new_text = htmlspecialchars($new_text);
		$stmt = $this->db_handler->prepare("UPDATE posts SET task_text = :new_text WHERE id = :task_id");
		
		$stmt->bindParam(':new_text', $new_text);
		$stmt->bindParam(':task_id',  $id, \PDO::PARAM_INT);

		$stmt->execute();

		$result = $stmt->rowCount();

		return $result;
		}
	}