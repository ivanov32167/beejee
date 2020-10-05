	<div class="container">
		<?php include 'main/views/filters.view.php'; ?>
		<?php
		
		if (is_array($data['posts']) && count($data['posts']) > 0)
			{
			$onoff_onclick = '';
			if ($data['admin'] === 1) { $onoff_onclick = ' onclick="switch_done_task(this)"'; }
				
			foreach($data['posts'] as $onepost)
				{
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
					
				echo '<div class="row" data-id="'.$onepost['id'].'">';
				echo	'<div class="col-md-9 mx-auto">';
				echo		'<div class="card mb-4 shadow-sm">';
				echo			'<div class="card-body">';
				echo				'<div class="d-flex flex-row justify-content-between">';
									$onepost['edited'] > 0 ? $edited = 'отредактировано администратором' : $edited = '';
				echo					'<small class="text-success">'.$edited .'</small>';
				echo					'<small class="text-muted">'.$onepost['u_name'].' ('.$onepost['u_mail'].')</small>';
				echo				'</div>';
				echo				'<p id="edit_text_'.$onepost['id'].'" class="card-text p-3">';
				echo					$onepost['task_text'];
				echo				'</p>';
				echo				'<div class="d-flex justify-content-between align-items-center">';
				echo					'<div class="btn-group">';
				echo					'<button type="button" class="btn btn-sm'.$active_class.'" '
											. 'data-active="'.$active_flag.'"'.$onoff_onclick.'>'.$active_text.'</button>';
									if ($data['admin'] === 1)
										{
										echo '<div id="edit_button_'.$onepost['id'].'" type="button" '
												. 'class="btn btn-sm btn-outline-secondary" '
												. 'onclick="edit_task(this, \'edit\')" '
												. 'data-task-field="task_text_'.$onepost['id'].'">Редактировать</div>';
										
										echo '<div class="btn btn-sm btn-outline-danger text-dark border-dark" '
												. 'onclick="delete_task(this)">Удалить</div>';					
										}
				echo					'</div>';
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
		<?php include 'main/views/pagination.view.php'; ?>
		<?php include 'main/views/add_tasks.view.php'; ?>
	</div>



