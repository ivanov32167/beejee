<?php
	$pag_offset_size = 3;

		if ($data['count'] > $GLOBALS['tasks_per_page'])
			{
			echo '<div class="d-flex justify-content-center">';
			echo	'<nav aria-label="Page navigation example">';
			echo		'<ul class="pagination">';
			
			if ($data['page'] > 1) // отображение кнопки "предыдущая страница"
				{
				echo		'<li class="page-item">';
				echo			'<a class="page-link" href="'.$GLOBALS['base_web_way'].($data['page'] - 1).'" aria-label="Previous">';
				echo				'<span aria-hidden="true">&laquo;</span>';
				echo			'</a>';
				echo		'</li>';
				}

			for ($p = $data['page'] - $GLOBALS['pag_offset_size']; $p <= $data['page'] + $GLOBALS['pag_offset_size']; $p++)  // отображение страниц
				{
				if ($p > 0 AND $p <= $data['page_limit'])
					{
					(int)$p === (int)$data['page'] ? $active_page = ' active' : $active_page = '';

					echo		'<li class="page-item'.$active_page.'">';
					echo			'<a class="page-link" href="'.$GLOBALS['base_web_way'].$p.'/">'.$p.'</a>';
					echo		'</li>';					
					}
				}

			if ($data['page'] + 1 <= $data['page_limit']) // отображение кнопки "следующая страница"
				{
				echo		'<li class="page-item">';
				echo			'<a class="page-link" href="'.$GLOBALS['base_web_way'].($data['page'] + 1).'" aria-label="Next">';
				echo				'<span aria-hidden="true">&raquo;</span>';
				echo			'</a>';
				echo		'</li>';				
				}
			echo		'</ul>';
			echo	'</nav>';
			echo '</div>';
			}
?>