<?php
spl_autoload_register(function ($class) 
	{
    $prefix = 'my\\'; // корень неймспейса
    $base_dir = __DIR__ . '/'; // корневая папка для автолоада

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) 
		{ return; }

    $relative_class = substr($class, $len); // относительный путь до класса

    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php'; // полный путь до класса
	
    if (is_readable($file))
		{ require $file; }
	});