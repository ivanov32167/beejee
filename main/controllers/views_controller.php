<?php
namespace my\controllers;


class views_controller
	{
	function generate($content_view, $template_view, $data = null)
		{

		if(is_array($data)) 
			{
			// преобразуем элементы массива в переменные
			//extract($data);
			}
		$data['csrf'] = $this->csrf_token();
		
		include 'main/views/'.$template_view;
		}

	public function csrf_token() 
		{
		$token = $_SESSION['csrf_token'] = substr( str_shuffle('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789'), 0, 20 );
		return $token;
		}
	}