<?php
/**
* ********************************************
* Description   : 计数器队列
* author        : zhuantou
* Create time   : 2011-12-03
* Last modified : 2011-12-05
* ********************************************
**/
ini_set('display_errors','on');
error_reporting(E_ALL & ~E_NOTICE); 
require_once dirname(__FILE__) . '/../include/start.php';
require_once dirname(__FILE__) . '/../include/autoload.php';

//echo "test";

$gm = new Gearman('worker');
$gm->addWork('counter', 'counter');

while(1){
    $gm->work();
}


/*
 * $data = array($key, $change, "decrement", $reset);
 * $data[0] = memcache键名
 * $data[1] = 变化值
 * $data[2] = decrement减少，increament
 * $data[3] = 当为true时设置number为0
 * 
 */
function counter($job){
	$data = unserialize($job->workload());
	//print_r($data);
	
	//入库
	$mysql = Db::getMysql();
	try {
		if ($data[3] == true) {
			$type = preg_replace('/counter_(.*)(_.*)/si', "\${1}", $data[0]);
			$mysql->replace("counter", array('name'=>$data[0], 'number'=>0, 'type'=>$type));
			return;
		} 
		
		
		if ($data[2] == "increment") {
			$sql = "update counter set number=number+". $data[1] ." where name=?";
		} elseif ($data[2] == "decrement") {
			$sql = "update counter set number=number-". $data[1] ." where name=?";
		} else {
			return false;
		}		
		$result = $mysql->execute($sql, $data[0]);
		if ($result == false) {
			$type = preg_replace('/counter_(.*)(_.*)/si', "\${1}", $data[0]);
			$mysql->insert("counter", array('name'=>$data[0], 'number'=>$data[1], 'type'=>$type));
		}
	} catch (Exception $e) {
		echo $e->getMessage()."\n";
	}
	
}
?>