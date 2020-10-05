
		<div class="d-flex justify-content-center">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Добавить задачу</button>
		</div>
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="add_task_header modal-title" id="exampleModalLabel">Новая задача</h5>
						<h5 class="add_success-title mx-auto text-success" hidden>Ваша задача добавлена</h5>

						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<input type="hidden" name="csrf" value="<?php echo $data['csrf'] ?>">
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">
									Пользователь:
									<small class="form_bad_name text-danger ml-3" hidden>
										слишком короткое имя!
									</small>
								</label>
								<input type="text" class="form-control" id="add_task_name" name="user">
							</div>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">
									Почта:
									<small class="form_bad_email text-danger ml-3" hidden>
										неверный email!
									</small>
								</label>
								<input type="email" class="form-control" id="add_task_email" name="email">
							</div>
							<div class="form-group">
								<label for="message-text" class="col-form-label">
									Задание:
									<small class="form_bad_content text-danger ml-3" hidden>
										слишком короткий текст задачи!
									</small>
								</label>
								<textarea class="form-control" id="message-text" name="content"></textarea>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
								<button type="button" class="btn btn-primary" onclick="create_task(this)">Сохранить</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>