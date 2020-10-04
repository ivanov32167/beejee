var form = document.querySelector('#submit');
	
form.addEventListener("click", ajax_authorise);

function ajax_authorise()
	{
	console.log('auth');
	var ajax_info = {};
	ajax_info.target = base_way + 'login';
	ajax_info.meth = 'POST';

	const login_query =	"csrf="		+ document.querySelector('input[name="csrf"]').value
					+ "&action="	+ '1'
					+ "&name="		+ document.querySelector('input[name="username"]').value
					+ "&pass="		+ document.querySelector('input[name="password"]').value;

	let result = ajax_action(ajax_info, login_query);

	result.then((ajax_answer)=>
		{
		if (ajax_answer === 'OK')
			{ window.location.href = base_way; }
		else
			{
			let bad_pass = document.querySelector('.bad_pass');

			bad_pass.hidden = false;

			setTimeout(() =>
				{
				bad_pass.classList.add('my_fade');
				}, 1000);
			setTimeout(() =>
				{
				bad_pass.hidden = true;
				bad_pass.classList.remove('my_fade');
				}, 6000);
			}
		});
	}

function ajax_logout()
	{
	var ajax_info = {};
	ajax_info.target = base_way + 'logout';
	ajax_info.csrf = document.querySelector('input[name="csrf"]').value;
	ajax_info.meth = 'POST';

	const logout_query = "csrf="	+ ajax_info.csrf 
					+ "&action="	+ '2';

	const result = ajax_action(ajax_info, logout_query);

	result.then((ajax_answer)=>
		{

		if (ajax_answer === 'LOGGED OUT')
			{ window.location.href = base_way; }
		else
			{ console.log('logout error') }
		});
	}

function ajax_action(info, query)
	{
	let prom = new Promise((resolve) =>
		{
		const request = new XMLHttpRequest();

		request.open(info.meth, info.target, true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.addEventListener("readystatechange", () => 
			{
			if(request.readyState === 4 && request.status === 200)
				{ resolve(request.response); }
			});

		request.send(query);
		});
	return prom;
	}


// редактирование удаление задач

function create_task()
	{
	//alert('ok');
	var ajax_info = {};
	ajax_info.target = base_way + 'addtask';
	ajax_info.csrf = document.querySelector('input[name="csrf"]').value;
	ajax_info.meth = 'POST';
	
	const add_task_query = "csrf="	+ ajax_info.csrf 
					  + "&user="	+ document.querySelector('input[name="user"]').value
					  + "&email="	+ document.querySelector('input[name="email"]').value
					  + "&content="	+ document.querySelector('textarea[name="content"]').value;

	const result = ajax_action(ajax_info, add_task_query);

	result.then((ajax_answer)=>
		{

		if (ajax_answer === 'TASK ADDED') { window.location.href = base_way; }
		else { console.log('TASK ADD ERROR') }
		});
	}

function delete_task(del_task_button)
	{
	var ajax_info = {};
	ajax_info.target = base_way + 'del';
	ajax_info.csrf = document.querySelector('meta[name="csrf-token"]').content;
	ajax_info.meth = 'POST';

	const logout_query = "csrf="	+ ajax_info.csrf 
						+ "&id="	+ del_task_button.closest('.row').dataset.id;

	const result = ajax_action(ajax_info, logout_query);

	result.then((ajax_answer)=>
		{
		if (ajax_answer === 'DELETE OK') { window.location.href = base_way; }
		else if (ajax_answer === 'NEED LOGIN') { window.location.href = base_way; }
		else { console.log('TASK DELETE ERROR') }
		});
	}

function switch_done_task(onoff_task_button)
	{
	var ajax_info = {};
	ajax_info.target = base_way + 'onoff';
	ajax_info.csrf = document.querySelector('meta[name="csrf-token"]').content;
	ajax_info.meth = 'POST';

	const logout_query = "csrf="	+ ajax_info.csrf 
						+ "&id="	+ onoff_task_button.closest('.row').dataset.id
						+ "&done="	+ onoff_task_button.dataset.active;

	const result = ajax_action(ajax_info, logout_query);

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
			{ window.location.href = base_way; }
		else
			{
			onoff_task_button.classList.remove('btn-secondary');
			onoff_task_button.classList.add('btn-success');
			onoff_task_button.dataset.active = 0;
			onoff_task_button.textContent = 'Завершена!';
			}
		});
	}

function edit_task(edit_elem, mode)
	{
	const task_id = edit_elem.closest('.row').dataset.id;
	const backup_field = document.querySelector('#backup_field');
	const edit_field = document.querySelector('#edit_text_' + task_id);
	const edit_button = document.querySelector('#edit_button_' + task_id);
	
	if (mode === 'edit')
		{
		console.log('mode edit');
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
		console.log('mode save');
		let content_to_save = edit_field.textContent;
		backup_field.textContent = '';
		edit_field.removeAttribute('onblur');
		edit_field.contentEditable = 'false';
		
		edit_button.textContent = 'Редактировать';
		edit_button.setAttribute('onclick', 'edit_task(this, \'edit\')');
		edit_button.classList.remove('btn-warning');
		edit_button.classList.add('btn-outline-secondary');
		
		save_new_task_content(content_to_save, task_id);
		}
	}

function save_new_task_content(content_to_save, task_id)
	{
	var ajax_info = {};
	ajax_info.target = base_way + 'edit';
	ajax_info.csrf = document.querySelector('meta[name="csrf-token"]').content;
	ajax_info.meth = 'POST';

	const edit_query = "csrf="	+ ajax_info.csrf 
						+ "&id="	+ task_id
						+ "&text="	+ content_to_save;

	const result = ajax_action(ajax_info, edit_query);

	result.then((ajax_answer)=>
		{

		if (ajax_answer === 'EDITED')
			{ window.location.href = base_way; }
		else if (ajax_answer === 'NEED LOGIN')
			{ window.location.href = base_way; }
		else
			{ console.log('EDIT ERROR') }
		});
	}