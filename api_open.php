<?php 
/**
* ********************************************
* Description   : 接口入口页
* author        : zhuantou
* Create time   : 2013-01-06 
* Last modified : 2013-01-06
* ********************************************
**/
ini_set('display_errors','on');
error_reporting(E_ALL & ~E_NOTICE); 
require_once dirname(__FILE__) . '/include/start.php';

$app = new App();
$result = $app->run();

if ($_GET['show'] == 'array') {
	print_r($result);exit; 
} else {
	$json = json_encode($result);
	echo $json;
}
 

	
?>