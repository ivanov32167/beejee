function ajax_authorise() // подготовка запроса для авторизации
	{
	//debugger;
	const target = base_way + 'login';

	const login_query =	"csrf="		+ document.querySelector('input[name="csrf"]').value
					+ "&action="	+ '1'
					+ "&name="		+ document.querySelector('input[name="username"]').value
					+ "&pass="		+ document.querySelector('input[name="password"]').value;

	let result = ajax_action(target, login_query);

	result.then((ajax_answer)=>
		{
		if (ajax_answer === 'OK')
			{ window.location.href = base_way; }
		else
			{
			show_validate_error('bad_pass');
			}
		});
	}

function ajax_login() // подготовка запроса для деавторизации
	{
	window.location.href = base_way + 'admin/';
	}

function ajax_logout() // подготовка запроса для деавторизации
	{
	const target = base_way + 'logout';

	const logout_query = "csrf="	+ document.querySelector('input[name="csrf"]').value
					+ "&action="	+ '2';

	const result = ajax_action(target, logout_query);

	result.then((ajax_answer)=>
		{
		if (ajax_answer === 'LOGGED OUT')
			{
			location.reload();
			}
		});
	}

function ajax_action(target, query) // отправка подготовленного аякс запроса
	{
	let prom = new Promise((resolve) =>
		{
		const request = new XMLHttpRequest();

		request.open('POST', target, true);
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

function create_task(form_elem) // подготовка запроса для создания задачи
	{
	let current_form = form_elem.closest('form');
	
	let form_name = current_form.querySelector('#add_task_name').value;
	let form_mail = current_form.querySelector('#add_task_email').value;
	let form_text = current_form.querySelector('#message-text').value;

	const email_regexp = /^[а-яёйА-ЯЁЙ\w\.\-]+[\@]{1}[\w\.]+\.[a-zA-Z]{2,5}$/;
	if (form_name.length < 1){show_validate_error('form_bad_name'); return;}
	if (form_mail.length < 4){show_validate_error('form_bad_email'); return;}
	if (email_regexp.test(String(form_mail)) === false){show_validate_error('form_bad_email'); return;}
	if (form_text.length < 1){show_validate_error('form_bad_content'); return;}
	
	const target = base_way + 'addtask';
	
	const add_task_query = "csrf="	+ document.querySelector('input[name="csrf"]').value
					  + "&user="	+ document.querySelector('input[name="user"]').value
					  + "&email="	+ document.querySelector('input[name="email"]').value
					  + "&content="	+ document.querySelector('textarea[name="content"]').value;

	const result = ajax_action(target, add_task_query);

	result.then((ajax_answer)=>
		{
		if (ajax_answer === 'TASK ADDED') 
			{
			show_validate_error('add_success-title');
			
			setTimeout(() =>
				{
				location.reload();
				}, 1500);
			}
		});
	}

function show_validate_error(message_class) // отображение ошибок заполнения формы
	{
	let error_field = document.querySelector('.' + message_class);

	error_field.hidden = false;

	setTimeout(() =>
		{
		error_field.classList.add('my_fade');
		}, 500);
	setTimeout(() =>
		{
		error_field.hidden = true;
		error_field.classList.remove('my_fade');
		}, 2000);
	}

function set_filter(filter_button) // установка фильтров списка задач
	{
	let filter_mode = 'none'
	if (filter_button.id === "filter_user") { filter_mode = 'user'; }
	if (filter_button.id === "filter_mail") { filter_mode = 'mail'; }
	if (filter_button.id === "filter_done") { filter_mode = 'done'; }
	
	const target = base_way + 'filter';

	const filter_query = "filter_mode="	+ filter_mode;

	const result = ajax_action(target, filter_query);

	result.then((ajax_answer)=>
		{

		if (ajax_answer === 'USER' || ajax_answer === 'MAIL' || ajax_answer === 'DONE')
			{
			location.reload();
			}
		});
	}