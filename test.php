<?php
/**
* ********************************************
* Description   : 不得姐--接口测试用例
* author        : zhuantou
* Create time   : 2012-02-29
* Last modified : 2012-03-12
* ********************************************
**/
ini_set('display_errors','on');
error_reporting(E_ALL & ~E_NOTICE); 
require_once dirname(__FILE__) . '/include/start.php';
$app = new JieApp();

$params = array('control'=>'data', 'action'=>'list', 'condition'=>array('type'=>3, 'notids'=>'46622', 'tag'=>'美丽|大方', 'maxid'=>'', 'per'=>'10', 'tag'=>'', 'page'=>'1', 'order'=>'id', 'sort'=>'desc'));
$result = $app->run($params);

print_r($result);exit; 


?>
