<?php
namespace my\controllers;

class user_controller
	{
	public $csrf;
	
	public function __construct()
		{
		$this->csrf = $_POST['csrf'];
		}
	
	public function login() // включение модераторских прав
		{
		if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] == $this->csrf)
			{
			if ($_POST['pass'] === '123' AND 
					($_POST['name'] === 'admin123' OR 
					 $_POST['name'] === 'Admin123' OR 
					 $_POST['name'] === 'admin' OR 
					 $_POST['name'] === 'Admin'))
				{
				$_SESSION['admin_mode'] = 1;
				
				echo 'OK';
				}
			else
				{ echo 'FAIL'; }
			}
		else
			{ echo 'CSRF FAIL'; }
		}

	public function logout() // выключение модераторских прав
		{
		if ($_SESSION['admin_mode'] === 1)
			{
			$_SESSION['admin_mode'] = 0;
			echo 'LOGGED OUT';
			}
		else
			{
			echo 'ADMIN STATUS ERROR';
			}
		}
	}