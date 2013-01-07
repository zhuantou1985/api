<?php
/**
* ********************************************
* Description   : 计数器测试
* author        : zhuantou
* Create time   : 2012-02-28
* Last modified : 2012-02-28
* ********************************************
**/
ini_set('display_errors','on');
error_reporting(E_ALL & ~E_NOTICE); 


$conn = mysql_connect("localhost","test","123456") or die ("error");
exit;

require_once dirname(__FILE__) . '/include/start.php';
require_once dirname(__FILE__) . '/include/autoload.php';

$memcache = new Memcache();
$memcache->connect('localhost', 11211);
echo "good";exit;


$counter = new Counter();
$counter->increment("pk_1", 1);
echo "----------\n".$counter->getCounter("pk_1");
?>
