<?php
/*
 * 数据操作类
 */
class Db{
	public static $db;
	public static $gm;
	public static $mysql;
	public static $memcache;
	private $type;
	
	public function __construct(){
		
	}
	
	/*
	 * gearman队列操作
	 */
	function execute($action, $data){
		if ($this->type == "gearman") {
			if ($action == "insert") {
				$this->getGearman()->doBack('mysql_insert', $data); 
			} elseif ($action == "update") {
				$this->getGearman()->doBack('mysql_update', $data);
			}
		} elseif ($this->type == "mysql") {
			if ($action == "insert") {
				$this->getMysql()->insert($data[0], $data[1]);
			} elseif ($action == "update") {
				$this->getMysql()->update($data[0], $data[1], $data[2], $data[3]);
			}
		}
	}
	
	
	/*
	 * 连接主从数据库
	 */
	public static function getMysql($isMaster=false){  
		if (is_object(self::$db)){  
            return self::$db;  
        }  
		$config = App::config();
		$master = $config['mysql']['master'];
		$slave = $config['mysql']['slave'];
		
		//print_r($slave);exit;
		
  		include_once dirname(__FILE__) . '/../common/mysql.php';
  		if ($isMaster == true) {
        	self::$db = new Mysql($master, array(), true); 
  		}else{
  			self::$db = new Mysql($master, $slave, false); 
  		} 
  		//print_r(self::$db);exit;
        self::$db->query("SET NAMES utf8");
        return self::$db;  
	}
	
	/*
	 * 连接Gearman
	 */
	public static function getGearman(){
		if (is_object(self::$gm)){  
            return self::$gm;  
        } 
		require dirname(__FILE__) . '/../common/gearman.php';
		if (class_exists('GearmanClient') == false) {
			self::$gm = false;
		} else {
			self::$gm = new Gearman('client');
		}
		
		return self::$gm;  
	}
	
	/*
	 * 连接memcache
	 */
	public static function getMemcache($machine=""){
		if (is_object(self::$memcache)){  
            return self::$memcache;  
        } 
		self::$memcache = new Memcache();
		if (($_SERVER['MACHINE'] == "code" && $machine != "online") || $machine == "code") { 
			self::$memcache->addServer('localhost', 11211); 
		} else {
			self::$memcache->addServer('192.168.133.10', 11211);  
			self::$memcache->addServer('192.168.133.2', 11211);  
		}
		
		//echo self::$memcache->getVersion();
		return self::$memcache;
	}
}
?>