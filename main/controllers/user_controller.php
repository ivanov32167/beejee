<?php
namespace my\controllers;

class user_controller {
	
	public $csrf;
	
	public function __construct()
		{
		$this->csrf = $_POST['csrf'];
		}
	
	public function login()
		{
		//$csrf = $_POST['csrf'];
		
		if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] == $this->csrf)
			{
			if ($_POST['name'] === '123' && $_POST['pass'] === '123')
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

	public function logout()
		{
		if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] == $this->csrf)
			{
			$_SESSION['admin_mode'] = 0;
			echo 'LOGGED OUT';
			}
		else
			{ echo 'CSRF FAIL'; }
		}
}