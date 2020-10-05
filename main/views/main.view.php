<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="<?php echo $data['csrf']; ?>">
	<title>ToDoList</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script>const base_way = "<?php echo $GLOBALS['base_web_way']; ?>";</script>
	<link href="<?php echo $GLOBALS['base_web_way']; ?>res/css/bootstrap_style_tail.css" rel="stylesheet">
</head>

<?php 
if (isset($data['page']) && $data['page'] > 1)	{ $saved_page = ' data-saved-page="'.$data['page'].'"'; }
else											{ $saved_page = ''; }
?>

<body<?php echo $saved_page;?>>
	<header>
		<div class="navbar navbar-dark bg-dark shadow-sm">
			<div class="container d-flex justify-content-between">
				<?php
				if (isset($data['admin']) && $data['admin'] === 1)
					{
					$loginOut_link = ' onclick="ajax_logout();"';
					$loginOut_text = 'Выйти';
					}
				else
					{
					$loginOut_link = ' onclick="ajax_login();"';
					$loginOut_text = 'Войти';
					}
				?>
				<div class="navbar-brand d-flex align-items-center">
					<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-key-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
					</svg>
					<strong class="loginout_btn"<?php echo $loginOut_link; ?>><?php echo $loginOut_text; ?></strong>
				</div>
			</div>
		</div>
	</header>
	<main role="main">
		
	<?php include 'main/views/'.$content_view; ?>
		
	</main>
	<script src="<?php echo $GLOBALS['base_web_way']; ?>res/js/loginout.js"></script>
	<?php
	if (isset($data['admin']) && $data['admin'] === 1)
		{ echo '<script src="'.$GLOBALS['base_web_way'].'res/js/admin.js"></script>'; }
	?>
</body>
</html>