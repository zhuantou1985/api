<?php
class Data{
	function __construct() {

	}
	
	function dataList($condition){	
		//列表数据 
		$this->params['from']   = !empty($condition['from']) 	? $condition['from']		: "";		//来源(ios,android,web)
		$this->params['market'] = !empty($condition['market'])  ? $condition['market'] 		: 0;		//来源市场
		$this->params['version']= !empty($condition['version'])	? $condition['version'] 	: "";		//版本号
		$this->params['page'] 	= !empty($condition['page']) 	? $condition['page']		: 1;		//页码
		$this->params['per'] 	= !empty($condition['per']) 	? $condition['per']			: 10;		//每页数量
		$this->params['order'] 	= !empty($condition['order'])	? $condition['order']		: "passtime";//排序字段
		$this->params['sort'] 	= !empty($condition['sort'])	? $condition['sort']		: "desc";	//desc降序，asc升序
		$this->params['cache'] 	= !empty($condition['cache']) 	? $condition['cache'] 		: 600;		//缓存时间 
		$this->params['nocache']= !empty($condition['nocache']) ? $condition['nocache'] 	: 0;		//是否取缓存
	
		
		//print_r($this->params);
		
		
		try { 
			$list = $this->getListMysql();
		} catch (Exception $e){
			echo $e->getMessage()."\n";
			return false;
		}
		
		return $list;
	}
	
	/**
	 * 数据列表
	 * @param 
	 * @return bool	
	 */
	function getListMysql(){
		$sql = "SELECT * FROM users LIMIT 10";
		$list = $this->getMysql()->getAll($sql);
		
		//print_r($list);
		return $list;
	}
	
	
	
	function getMemcache($machine=""){
		if (is_object($this->memcache) == false){
			$this->memcache = Db::getMemcache($machine);
		} 
		return $this->memcache;
	}
	
	
	function getMysql($isMaster=0){
		if (is_object($this->mysql[$isMaster]) == false){
			$this->mysql[$isMaster] = Db::getMysql($isMaster);     
		} 
		return $this->mysql[$isMaster];
	}
}
