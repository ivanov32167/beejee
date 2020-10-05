<?php
namespace my\controllers;

class views_controller
	{
	function generate($content_view, $template_view, $data = null) // я даже не знаю что тут можно комментировать =\....
		{
		$data['csrf'] = $this->csrf_token();
		
		include 'main/views/'.$template_view;
		}

	public function csrf_token() // создание CSRF токена
		{
		$token = $_SESSION['csrf_token'] = substr( str_shuffle('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789'), 0, 20 );
		
		return $token;
		}
	}