<?php
class App {
	// run
	public function run($params=""){
		try {
			$this->init();  // 初始化
			return $this->exec($params);   // 开始加载控制器并运行方法
		} catch (Exception $e){
			//echo $e->getMessage()."\n";   // 捕获异常
		} 
	}
	
	// 初始化
	public function init(){ 
		// 项目编译
		$this->bulid();
		// 设置错误级别
		// 设置系统时区 PHP5支持
		// 清除危险变量
		// 解析魔术引号
		// 禁止对全局变量注入
		// 定义一些要用到的常量
	}
	
	// 项目编译
	public function bulid(){
		// 加载核心配置
		// 加载用户配置
		// 加载RULE规则
		// 加载语言包
		// 加载兼容函数库
		require_once dirname(__FILE__) . '/autoload.php';
		require_once dirname(__FILE__) . '/../common/common.php';
	}
	
	//用户配置
	static function config($key=""){
		include dirname(__FILE__) . '/../config/main.php';
		if ($key) {
			return $config[$key];
		} else {
			return $config;
		} 
		
	}
  
	// 运行控制器
	public function exec($params){
		// 分析 URL 模式
		$parseUrl = $this->parseUrl($params);
		$control = $parseUrl['control'];
		$action = $parseUrl['action'];
		$condition = $parseUrl['condition'];
		
		// 获取 M AND A
		// 加载控制器
		// 实例化控制器
		$class = strtolower($control);
		$class = ucfirst($class)."Controller";
		
		$method = "action".ucfirst($action);
		
		if (is_file(dirname(__FILE__) . '/../controllers/'.$class.'.php')) {
			require_once dirname(__FILE__) . '/../controllers/'.$class.'.php';
		} else {
			echo "ERROR：控制器不存在"; exit;
		}
		
		$app = new $class;
		// 运行指定的方法
		$result = $app->$method($condition);
		return $result;
		
	}
	
	// 分析 URL 模式
	public function parseUrl($params=""){ 
		// 分析GET参数,包括控制器名和方法以及其它的GET参数
		// 分析路由规则
		
		if ($params) {
			return $params;
		} else {
			$params['control'] = $_REQUEST['c'];
			$params['action'] = $_REQUEST['a'];
			$params['condition'] = $_REQUEST;
			return $params;	
		}
		
	}
}