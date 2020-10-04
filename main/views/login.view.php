<h1 class="w-25 mx-auto">Авторизация</h1>
<div class="w-25 mx-auto container-sd">
	<form>
		<input type="hidden" name="csrf" value="<?php echo $data['csrf'] ?>">
		<div class="form-group">
			<label for="exampleInputEmail1">Имя пользователя</label>
			<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username" value="123">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Пароль <small class="bad_pass text-danger ml-3" hidden>неверный пароль!</small></label>
			<input type="password" class="form-control" id="exampleInputPassword1" name="password" value="123">
		</div>
		<button id="submit" type="button" class="btn btn-primary" onsubmit="ajax_authorise()">Войти</button>
		
	</form>
</div>
