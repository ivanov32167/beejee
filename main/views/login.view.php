<h1 class="w-25 mx-auto">Авторизация</h1>
<div class="w-25 mx-auto container-sd">
	<form>
		<input type="hidden" name="csrf" value="<?php echo $data['csrf'] ?>">
		<div class="form-group">
			<label>Имя пользователя</label>
			<input type="email" class="form-control" aria-describedby="emailHelp" name="username">
		</div>
		<div class="form-group">
			<label>Пароль</label>
			<input type="password" class="form-control" name="password">
		</div>
		<div class="btn btn-primary" onclick="ajax_authorise()">Войти</div>
		<small class="bad_pass text-danger ml-3" hidden>неверныe данные!</small>
	</form>
</div>
