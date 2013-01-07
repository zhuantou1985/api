<?php
header("Content-type: text/html; charset=utf-8"); 
date_default_timezone_set('Asia/Chongqing');
ini_set('display_errors','on');
error_reporting(E_ALL & ~E_NOTICE); 

function __autoload($classname)
{
	$basePath = App::config("basePath");
	
	$file_name = strtolower($classname) . '.php';
	
	$path = $basePath . '/model/';
	$paths[] = $path;
	
	$path = $basePath . '/common/';
	$paths[] = $path;
	
	foreach ($paths as $p)
	{
		$full_path = $p . $file_name;
		if (file_exists($full_path))
		{
			require_once $full_path;
			return;
		}
	}
}
?>