<?php
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