<?php
require("app/lib/Dev.php");
//require("app/core/Router.class.php");
use app\core\Router;

spl_autoload_register(function ($class) {
	$pth = str_replace('\\', '/', $class.'.class.php');
	if (file_exists($pth))
		require $pth;
});

session_start();

$var = new Router;
$var->run();