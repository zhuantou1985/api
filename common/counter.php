<?php
/**
* ********************************************
* Description   : 计数器类
* author        : zhuantou
* Create time   : 2012-02-24
* Last modified : 2012-02-24
* ********************************************
**/
class Counter{
	function __construct() {
		$this->gearman = Db::getGearman();
		$this->memcache = Db::getMemcache();
		$this->key_prefix = "counter_";//计数KEY的前缀
	}
	
	/**
	 * 计数增加
	 * @param $key 		Memcache的key
	 * @param $change	变化值
	 * @return		
	 */
	function increment($key, $change="1"){
		$key = $this->key_prefix . $key;
		//当memcache值是负数时，将引起memcache出错!!!
		$number = $this->memcache->get($key);
		if ($number < 0 || $number == "") {
			$this->memcache->set($key, 1);
		} else {
			$result = $this->memcache->increment($key, $change);
		}
		
		//队列入库
		$data = array($key, $change, "increment");
		$this->gearman->doBack('counter', $data);
	}
	
	/**
	 * 计数减少
	 * @param $key 		Memcache的key
	 * @param $change	变化值  	
	 * @return		
	 */
	function decrement($key, $change="1"){
		$key = $this->key_prefix . $key;
		//$result = $this->memcache->set($key, 5);
		$result = $this->memcache->decrement($key, $change);
		if ($result == false) {
			$this->memcache->set($key, 0);
			$reset = true;	//复位为0
		}
		echo $result;
		//队列入库
		$data = array($key, $change, "decrement", $reset);
		$this->gearman->doBack('counter', $data);
	}
	
	/**
	 * 获取计数值
	 * @param $key 		Memcache的key
	 * @param $type		当type等于1时直接从数据库里取数据  	
	 * @return		
	 */
	function getCounter($key, $type=0){
		$key = $this->key_prefix . $key;
		
		//如果memcache服务不正常则从数据库里取
		if ($this->memcache == false || $type == 1) {
			$mysql = Db::getMysql();
			$sql = "select number from counter where name=?";
			$number = $mysql->getOne($sql, $key);
			return $number;
		} else {
			return $this->memcache->get($key);
		}
	}
}

?>