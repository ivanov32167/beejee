function delete_task(del_task_button) // удаление задачи
	{
	const target = base_way + 'del';

	const logout_query = "csrf="	+ document.querySelector('meta[name="csrf-token"]').content
						+ "&id="	+ del_task_button.closest('.row').dataset.id;

	const result = ajax_action(target, logout_query);

	result.then((ajax_answer)=>
		{
		if (ajax_answer === 'DELETE OK') { location.reload(); }
		else if (ajax_answer === 'NEED LOGIN') { redirect_to_login_page(); }
		else { console.log('TASK DELETE ERROR') }
		});
	}

function switch_done_task(onoff_task_button) // изменение статуса задачи
	{
	const target = base_way + 'onoff';

	const on_off_query = "csrf="	+ document.querySelector('meta[name="csrf-token"]').content
						+ "&id="	+ onoff_task_button.closest('.row').dataset.id
						+ "&done="	+ onoff_task_button.dataset.active;

	const result = ajax_action(target, on_off_query);

	result.then((ajax_answer)=>
		{
		if (Number(ajax_answer) === 1)
			{
			onoff_task_button.classList.remove('btn-success');
			onoff_task_button.classList.add('btn-secondary');
			onoff_task_button.dataset.active = 1;
			onoff_task_button.textContent = 'В процессе';
			}
		else if (ajax_answer === 'NEED LOGIN')
			{ redirect_to_login_page(); }
		else
			{
			onoff_task_button.classList.remove('btn-secondary');
			onoff_task_button.classList.add('btn-success');
			onoff_task_button.dataset.active = 0;
			onoff_task_button.textContent = 'Завершена!';
			}
		});
	}

function edit_task(edit_elem, mode) // работа с текстом задачи
	{
	const task_id = edit_elem.closest('.row').dataset.id;
	const backup_field = document.querySelector('#backup_field');
	const edit_field = document.querySelector('#edit_text_' + task_id);
	const edit_button = document.querySelector('#edit_button_' + task_id);
	
	if (mode === 'edit')
		{
		edit_button.textContent = 'Сохранить';
		edit_button.setAttribute('onclick', 'edit_task(this, \'save\')');
		edit_button.classList.remove('btn-outline-secondary');
		edit_button.classList.add('btn-warning');
		
		
		
		backup_field.textContent = edit_field.textContent;
		edit_field.contentEditable = 'true';
		edit_field.focus();
		edit_field.setAttribute('onblur', 'edit_task(this, \'reset\')');
		}
	
	if (mode === 'save')
		{
		let content_to_save = edit_field.textContent;
		
		edit_field.removeAttribute('onblur');
		edit_field.contentEditable = 'false';
		
		edit_button.textContent = 'Редактировать';
		edit_button.setAttribute('onclick', 'edit_task(this, \'edit\')');
		edit_button.classList.remove('btn-warning');
		edit_button.classList.add('btn-outline-secondary');

		if (content_to_save === backup_field.textContent) // если контент не был изменен - ничего не делать
			{
			backup_field.textContent = '';
			return;
			}
		else // иначе - сохранить изменения
			{
			backup_field.textContent = '';
			save_new_task_content(content_to_save, task_id);
			}
		}
	}

function save_new_task_content(content_to_save, task_id) // сохранение измененного текста задачи
	{
	const target = base_way + 'edit';

	const edit_query = "csrf="	+ document.querySelector('meta[name="csrf-token"]').content
					+ "&id="	+ task_id
					+ "&text="	+ content_to_save;

	const result = ajax_action(target, edit_query);

	result.then((ajax_answer)=>
		{

		if (ajax_answer === 'EDITED')
			{ location.reload(); }
		else if (ajax_answer === 'NEED LOGIN')
			{ redirect_to_login_page(); }
		else
			{ console.log('EDIT ERROR') }
		});
	}

function redirect_to_login_page() // переход на страницу авторизации, при необходимости
	{
	window.location.href = base_way + 'admin/';
	}