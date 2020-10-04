	<div class="container">
		<div class="d-flex justify-content-center">
			<h1>Список задач</h1>
		</div>
		<div class="d-flex justify-content-center">
			<h5>Сортировка</h5>
		</div>
		<div class="w-50 mx-auto d-flex flex-row bd-highlight mb-3 justify-content-center">
			<div id="filter_user" class="w-33 flex-fill bd-highlight border border-dark rounded-left text-center text-white bg-secondary">пользователь</div>
			<div id="filter_mail" class="w-33 flex-fill bd-highlight border-bottom border-top border-dark text-center text-white bg-success">эл. почта</div>
			<div id="filter_status" class="w-33 flex-fill bd-highlight border border-dark rounded-right text-center text-white bg-secondary">готовность</div>
		</div>
		<?php
		
		if ($data['admin'] === 1)
			{
			$del_btn_onclick = '';
			}
		else
			{
			$del_btn_onclick = '';
			}
		
		if (is_array($data['posts']) && count($data['posts']) > 0)
			{
			$onoff_onclick = '';
			if ($data['admin'] === 1)
				{ $onoff_onclick = ' onclick="switch_done_task(this)"'; }
				
			foreach($data['posts'] as $onepost)
				{
				
				echo '<div class="row" data-id="'.$onepost['id'].'">';
				echo	'<div class="col-md-9 mx-auto">';
				echo		'<div class="card mb-4 shadow-sm">';
				echo			'<div class="card-body">';
				echo				'<p id="edit_text_'.$onepost['id'].'" class="card-text p-3">';
				echo					$onepost['task_text'];
				echo				'</p>';
				echo				'<div class="d-flex justify-content-between align-items-center">';
				echo					'<div class="btn-group">';
				//echo '<h1>'.var_dump($onepost['active']+0).'</h1>';
				if ($onepost['active'] + 0 === 1)
					{
					$active_flag = 1;
					$active_class = ' btn-secondary';
					$active_text = 'В процессе';
					}
				else								
					{
					$active_flag = 0;
					$active_class = ' btn-success';
					$active_text = 'Завершена';
					}
				
				echo					'<button type="button" class="btn btn-sm'.$active_class.'" '
											. 'data-active="'.$active_flag.'"'.$onoff_onclick.'>'.$active_text.'</button>';
				
				if ($data['admin'] === 1)
					{
					echo					'<div id="edit_button_'.$onepost['id'].'" type="button" class="btn btn-sm btn-outline-secondary" '
												. 'onclick="edit_task(this, \'edit\')" data-task-field="task_text_'.$onepost['id'].'">Редактировать</div>';
					echo					'<div type="button" class="btn btn-sm btn-outline-danger text-dark border-dark" '
												. 'onclick="delete_task(this)">Удалить</div>';					
					}
				
				echo					'</div>';
				echo					'<small class="text-muted">'.$onepost['u_name'].'</small>';
				echo				'</div>';
				echo			'</div>';
				echo		'</div>';
				echo	'</div>';
				echo '</div>';
				if ($data['admin'] === 1)
					{
					echo '<div id="backup_field" class="d-none"></div>';
					}
				}
			}
		?>
	</div>


<?php
		if ($data['count'] > 3)
			{
			echo '<div class="d-flex justify-content-center">';
			echo	'<nav aria-label="Page navigation example">';
			echo		'<ul class="pagination">';
			
			if ($data['page'] > 1) // отображение кнопки "предыдущая страница"
				{
				echo '<li class="page-item">';
				echo	'<a class="page-link" href="'.$GLOBALS['base_web_way'].($data['page'] - 1).'" aria-label="Previous">';
				echo		'<span aria-hidden="true">&laquo;</span>';
				echo	'</a>';
				echo '</li>';
				}

			for ($p = $data['page'] - 1; $p <= $data['page'] + 1; $p++)  // отображение страниц
				{
				$page = $p === 0 ? $p = 1: $p;
				
				(int)$p === (int)$data['page'] ? $active_page = ' active' : $active_page = '';

				echo '<li class="page-item'.$active_page.'">';
				echo	'<a class="page-link" href="'.$GLOBALS['base_web_way'].$page.'/">'.$page.'</a>';
				echo '</li>';
				
				if ($page >= $data['page_limit']) { break; }
				}

			if ($data['page'] + 1 <= $data['page_limit']) // отображение кнопки "следующая страница"
				{
				echo '<li class="page-item">';
				echo	'<a class="page-link" href="'.$GLOBALS['base_web_way'].($data['page'] + 1).'" aria-label="Next">';
				echo		'<span aria-hidden="true">&raquo;</span>';
				echo	'</a>';
				echo '</li>';				
				}

			echo		'</ul>';
			echo	'</nav>';
			echo '</div>';
			}
?>

		<div class="d-flex justify-content-center">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Добавить задачу</button>
		</div>
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Новая задача</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<input type="hidden" name="csrf" value="<?php echo $data['csrf'] ?>">
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Пользователь:</label>
								<input type="text" class="form-control" id="recipient-name" name="user">
							</div>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Почта:</label>
								<input type="email" class="form-control" id="recipient-name" name="email">
							</div>
							<div class="form-group">
								<label for="message-text" class="col-form-label">Задание:</label>
								<textarea class="form-control" id="message-text" name="content"></textarea>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
								<button type="button" class="btn btn-primary" onclick="create_task()">Сохранить</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>